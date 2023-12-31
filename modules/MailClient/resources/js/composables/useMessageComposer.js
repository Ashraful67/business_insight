/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { ref, unref, computed, onBeforeMount } from 'vue'
import { watchDebounced } from '@vueuse/core'
import findIndex from 'lodash/findIndex'
import find from 'lodash/find'
import { useRecordStore } from '~/Core/resources/js/composables/useRecordStore'
import { useI18n } from 'vue-i18n'
import { randomString } from '@/utils'
import { useStore } from 'vuex'
import { useForm } from '~/Core/resources/js/composables/useForm'
import { useSignature } from '../views/Emails/useSignature'

export function useMessageComposer(viaResource, resourceRecord) {
  const { t } = useI18n()
  const store = useStore()
  const { addSignature } = useSignature()
  const { addResourceRecordHasManyRelationship, incrementResourceRecordCount } =
    useRecordStore()

  const sending = ref(false)
  const customAssociationsValue = ref({})
  const attachmentsDraftId = ref(randomString())
  const attachments = ref([])
  const parsedSubject = ref(null)
  const subject = ref(null)

  const { form } = useForm({
    with_task: false,
    task_date: null,
    message: addSignature(),
    to: [],
    cc: null,
    bcc: null,
    associations: {},
  })

  const placeholders = computed(() => store.state.fields.placeholders)

  const allPlaceholders = computed(() => {
    let all = []

    Object.keys(placeholders.value).forEach(group => {
      placeholders.value[group].placeholders.forEach(placeholder => {
        all.push(placeholder)
      })
    })

    return all
  })

  const allPlaceholdersInterpolations = computed(() => {
    return allPlaceholders.value.reduce((tags, p) => {
      const tag = [p.interpolation_start, p.interpolation_end]

      if (tags.length === 0) {
        tags.push(tag)
      } else {
        tags.forEach(i => {
          if (i[0] !== tag[0] && i[1] !== tag[1]) {
            tags.push(tag)
          }
        })
      }

      return tags
    }, [])
  })

  const resourcesForPlaceholders = computed(() => {
    const resources = []

    if (form.to.length > 0 && form.to[0].resourceName) {
      resources.push({
        name: form.to[0].resourceName,
        id: form.to[0].id,
      })
    }

    // viaResource
    if (viaResource) {
      resources.push({
        name: viaResource,
        id: unref(resourceRecord).id,
      })
    }

    return resources
  })

  const subjectPlaceholders = computed(() => {
    if (!placeholders.value || !subject.value) {
      return []
    }

    const usedPlaceholders = []

    allPlaceholdersInterpolations.value.forEach(i => {
      const matches = new RegExp(`${i[0]}\\s?(.*)\\s?${i[1]}`).exec(
        subject.value
      )

      if (matches) {
        usedPlaceholders.push({
          interpolation_start: i[0],
          interpolation_end: i[1],
          tag: matches[1].trim(),
        })
      }
    })

    return usedPlaceholders
  })

  const hasInvalidSubjectPlaceholders = computed(() => {
    let value = false

    subjectPlaceholders.value.forEach(p => {
      if (!find(allPlaceholders.value, ['tag', p.tag])) {
        value = true
        return false
      }

      return true
    })

    return value
  })

  const subjectPlaceholdersSyntaxIsValid = computed(() => {
    if (!subject.value) {
      return true
    }

    let value = true

    allPlaceholders.value.concat(subjectPlaceholders.value).every(p => {
      if (subject.value.indexOf(p.tag) > -1) {
        if (
          !new RegExp(
            `${p.interpolation_start}\\s?${p.tag}\\s?${p.interpolation_end}`
          ).test(subject.value)
        ) {
          value = false
          return false
        }
      }
      return true
    })

    return value
  })

  const subjectContainsPlaceholders = computed(() => {
    return subjectPlaceholders.value.length > 0
  })

  const hasInvalidAddresses = computed(() => {
    return Boolean(
      form.errors.first('to.0.address') ||
        form.errors.first('cc.0.address') ||
        form.errors.first('bcc.0.address')
    )
  })

  const wantsCc = computed(() => form.cc !== null)
  const wantsBcc = computed(() => form.bcc !== null)

  function parsePlaceholdersForMessage() {
    _parsePlaceholders(form.message, 'input-fields').then(
      content => (form.message = content)
    )
  }

  function parsePlaceholdersForSubject() {
    if (
      !subjectContainsPlaceholders.value ||
      !subjectPlaceholdersSyntaxIsValid.value
    ) {
      return
    }

    _parsePlaceholders(subject.value, 'interpolation').then(
      content => (parsedSubject.value = content)
    )
  }

  async function _parsePlaceholders(content, type) {
    if (!content) {
      return
    }

    if (resourcesForPlaceholders.value.length === 0) {
      return content
    }

    return makeParsePlaceholdersRequest(
      resourcesForPlaceholders.value,
      content,
      type
    )
  }

  function handleCreatedFollowUpTask(task) {
    addResourceRecordHasManyRelationship(task, 'activities')
    incrementResourceRecordCount('incomplete_activities_for_user_count')
  }

  function sendRequest(url) {
    sending.value = true
    form.subject = parsedSubject.value || subject.value
    form.fill('attachments_draft_id', attachmentsDraftId)

    if (viaResource) {
      form.fill('via_resource', viaResource)
      form.fill('via_resource_id', unref(resourceRecord).id)
    }

    return Innoclapps.request()
      .post(url, form.data())
      .then(response => {
        form.reset()

        if (response.status !== 202) {
          Innoclapps.success(t('mailclient::inbox.message_sent'))
          Innoclapps.$emit('email-sent', response.data.message)
        } else {
          Innoclapps.info(t('mailclient::mail.message_queued_for_sending'))
        }

        if (response.data.createdActivity && viaResource) {
          handleCreatedFollowUpTask(response.data.createdActivity)
        }
      })
      .finally(() => (sending.value = false))
  }

  function setWantsCC() {
    form.cc = []
  }

  function setWantsBCC() {
    form.bcc = []
  }

  function handleAttachmentUploaded(media) {
    attachments.value.push(media)
  }

  function destroyPendingAttachment(media) {
    Innoclapps.request()
      .delete(`/media/pending/${media.pending_data.id}`)
      .then(() => {
        let index = findIndex(attachments.value, ['id', media.id])
        attachments.value.splice(index, 1)
      })
  }

  function handleRecipientSelectedEvent(recipients) {
    associateSelectedRecipients(recipients)
    parsePlaceholdersForMessage()
    parsePlaceholdersForSubject()
  }

  function handleToRecipientRemovedEvent(option) {
    dissociateRemovedRecipients(option)
    parsePlaceholdersForMessage()
    parsePlaceholdersForSubject()
  }

  /**
   * When a recipient is removed we will dissociate
   * the removed recipients from the associations component
   *
   * @param  {Object} option
   *
   * @return {Void}
   */
  function dissociateRemovedRecipients(option) {
    if (
      !option.resourceName ||
      !customAssociationsValue.value[option.resourceName]
    ) {
      return
    }

    let index = findIndex(customAssociationsValue.value[option.resourceName], [
      'id',
      option.id,
    ])

    if (index !== -1) {
      customAssociationsValue.value[option.resourceName].splice(index, 1)
    }
  }

  /**
   * When a recipient is selected we will associate automatically to the associatiosn component
   *
   * @param  {Array} records
   *
   * @return {Void}
   */
  function associateSelectedRecipients(records) {
    records.forEach(record => {
      if (record.resourceName) {
        if (!customAssociationsValue.value[record.resourceName]) {
          customAssociationsValue.value[record.resourceName] = []
        }

        if (
          !find(customAssociationsValue.value[record.resourceName], [
            'id',
            record.id,
          ])
        ) {
          customAssociationsValue.value[record.resourceName].push({
            id: record.id,
            display_name: record.name,
          })
        }
      }
    })
  }

  async function makeParsePlaceholdersRequest(resources, content, type) {
    if (!content) {
      return content
    }

    let { data } = await Innoclapps.request().post('/placeholders/' + type, {
      resources: resources,
      content: content,
    })

    return data
  }

  watchDebounced(
    subject,
    () => {
      parsePlaceholdersForSubject()
    },
    { debounce: 600 }
  )

  onBeforeMount(() => {
    store.dispatch('fields/fetchPlaceholders')
  })

  return {
    form,
    sending,
    customAssociationsValue,
    attachments,
    attachmentsDraftId,

    placeholders,
    resourcesForPlaceholders,
    parsedSubject,
    subject,
    hasInvalidAddresses,
    wantsCc,
    wantsBcc,

    sendRequest,
    subjectContainsPlaceholders,
    parsePlaceholdersForMessage,
    parsePlaceholdersForSubject,
    subjectPlaceholdersSyntaxIsValid,
    hasInvalidSubjectPlaceholders,
    handleAttachmentUploaded,
    destroyPendingAttachment,
    associateSelectedRecipients,
    dissociateRemovedRecipients,
    handleRecipientSelectedEvent,
    handleToRecipientRemovedEvent,
    setWantsBCC,
    setWantsCC,
  }
}
