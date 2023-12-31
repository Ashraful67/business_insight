<template>
  <div class="mx-auto max-w-3xl" v-show="visible">
    <div class="relative">
      <ITabGroup>
        <ITabList>
          <ITab
            :title="$t('documents::document.document_details')"
            icon="AdjustmentsVertical"
          />
          <ITab
            :disabled="Object.keys(document).length === 0"
            :title="$t('documents::document.document_activity')"
            icon="DocumentText"
          />
        </ITabList>
        <ITabPanels>
          <ITabPanel>
            <IAlert
              v-if="document.status === 'accepted'"
              variant="info"
              class="mb-6"
            >
              {{ $t('documents::document.limited_editing') }}
            </IAlert>
            <div
              class="my-3 flex items-center md:absolute md:right-1 md:top-3.5 md:my-0 md:space-x-2.5"
            >
              <div
                class="order-last ml-auto mr-0 place-self-end md:-order-none md:mr-2.5"
              >
                <slot name="actions"></slot>
              </div>

              <TextBackground
                v-if="selectedDocumentType"
                :color="selectedDocumentType.swatch_color"
                class="mr-2.5 inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-sm/5 font-normal dark:!text-white md:mr-0"
              >
                <Icon
                  :icon="selectedDocumentType.icon"
                  class="mr-1.5 h-4 w-4 text-current"
                />
                {{ selectedDocumentType.name }}
              </TextBackground>

              <TextBackground
                :color="
                  document.status
                    ? statuses[document.status].color
                    : statuses.draft.color
                "
                class="mr-2.5 inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-sm/5 font-normal dark:!text-white md:mr-0"
              >
                {{
                  $t(
                    'documents::document.status.' +
                      (document.status ? document.status : statuses.draft.name)
                  )
                }}
              </TextBackground>
            </div>

            <slot name="top"></slot>

            <IFormGroup
              :label="$t('brands::brand.brand')"
              label-for="brand_id"
              required
            >
              <ICustomSelect
                :options="brands"
                :clearable="false"
                input-id="brand_id"
                :disabled="document.status === 'accepted'"
                label="name"
                v-model="selectedBrand"
                @update:modelValue="form.brand_id = $event.id"
              />
              <IFormError v-text="form.getError('brand_id')" />
            </IFormGroup>

            <IFormGroup
              :label="$t('documents::document.title')"
              label-for="title"
              required
            >
              <IFormInput
                v-model="form.title"
                id="title"
                :disabled="document.status === 'accepted'"
              />
              <IFormError v-text="form.getError('title')" />
            </IFormGroup>
            <IFormGroup
              :label="$t('documents::document.type.type')"
              label-for="document_type_id"
              required
            >
              <ICustomSelect
                :options="documentTypes"
                :clearable="false"
                input-id="document_type_id"
                label="name"
                v-model="selectedDocumentType"
                @update:modelValue="form.document_type_id = $event.id"
              />
              <IFormError v-text="form.getError('document_type_id')" />
            </IFormGroup>

            <IFormGroup
              :label="$t('documents::fields.documents.user.name')"
              label-for="user_id"
              required
            >
              <ICustomSelect
                label="name"
                input-id="user_id"
                :clearable="false"
                :options="users"
                :disabled="document.status === 'accepted'"
                v-model="selectedUser"
                @update:modelValue="form.user_id = $event ? $event.id : null"
              />
              <IFormError v-text="form.getError('user_id')" />
            </IFormGroup>

            <h3
              class="my-2 text-sm font-medium text-neutral-800 dark:text-neutral-100"
              v-t="'documents::document.view_type.html_view_type'"
            />
            <FormViewTypes v-model="form.view_type" />
            <IFormError v-text="form.getError('view_type')" />
          </ITabPanel>
          <ITabPanel>
            <ul class="space-y-4 text-sm">
              <li v-for="log in changelog" :key="log.id" class="relative">
                <div class="flex flex-col justify-between sm:flex-row">
                  <div
                    class="sm:order-0 order-1 text-neutral-800 dark:text-neutral-300 sm:flex sm:items-center"
                  >
                    <span
                      class="absolute -top-0.5 mt-1.5 h-3 w-3 rounded-full sm:relative sm:-top-0 sm:mr-2 sm:mt-0"
                      :class="
                        log.properties.type === 'success'
                          ? 'bg-success-500'
                          : 'bg-neutral-200'
                      "
                    />
                    {{ $t(log.properties.lang.key, log.properties.lang.attrs) }}
                  </div>
                  <span
                    class="order-0 ml-5 mt-px text-neutral-400 sm:order-1 sm:ml-5 sm:self-end"
                    v-text="localizedDateTime(log.created_at)"
                  />
                </div>

                <div
                  v-if="log.properties.section"
                  class="mt-2 rounded-sm border border-neutral-200 px-4 py-5 dark:border-neutral-700 sm:ml-5"
                >
                  <h4
                    class="mb-2 text-base font-medium text-neutral-800 dark:text-neutral-300"
                    v-text="
                      $t(
                        log.properties.section.lang.key,
                        log.properties.section.lang.attrs || {}
                      )
                    "
                  />
                  <ul>
                    <li
                      v-for="(data, sIdx) in log.properties.section.list"
                      :key="sIdx"
                      class="text-neutral-600 dark:text-neutral-400"
                      v-text="$t(data.lang.key, data.lang.attrs || {})"
                    />
                  </ul>
                </div>
              </li>
            </ul>
          </ITabPanel>
        </ITabPanels>
      </ITabGroup>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, inject } from 'vue'
import propsDefinition from './formSectionProps'
import find from 'lodash/find'
import TextBackground from '~/Core/resources/js/components/TextBackground.vue'
import FormViewTypes from '../views/DocumentFormViewTypes.vue'
import { useDates } from '~/Core/resources/js/composables/useDates'
import { useDocumentTypes } from '../composables/useDocumentTypes'
import { useApp } from '~/Core/resources/js/composables/useApp'

const props = defineProps(propsDefinition)

const { localizedDateTime } = useDates()

const statuses = Innoclapps.config('documents.statuses')
const selectedUser = ref(null)
const selectedDocumentType = ref(null)
const selectedBrand = ref(null)

const brands = inject('brands')

const { users } = useApp()
const { typesByName: documentTypes } = useDocumentTypes()

const changelog = computed(() => {
  if (!props.document.changelog) {
    return []
  }
  return props.document.changelog.slice().reverse()
})

function prepareComponent() {
  if (!props.form.brand_id) {
    selectedBrand.value = find(brands.value, brand => brand.is_default)

    if (selectedBrand.value) {
      props.form.set('brand_id', selectedBrand.value.id)
    }
  } else {
    selectedBrand.value = find(brands.value, ['id', props.form.brand_id])
  }

  if (props.form.document_type_id) {
    selectedDocumentType.value = find(documentTypes.value, [
      'id',
      props.form.document_type_id,
    ])
  }

  if (props.form.user_id) {
    selectedUser.value = find(users.value, ['id', props.form.user_id])
  }
}

prepareComponent()
</script>
