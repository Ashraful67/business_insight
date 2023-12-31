<template>
  <ICard
    tag="form"
    :header="$t('brands::brand.update')"
    @submit.prevent="save"
    @keydown="form.onKeydown($event)"
    no-body
    :overlay="!componentReady"
  >
    <div v-if="componentReady">
      <ITabGroup>
        <ITabList class="px-4 sm:px-6">
          <ITab :title="$t('brands::brand.form.sections.general')" />
          <ITab :title="$t('brands::brand.form.sections.navigation')" />
          <ITab :title="$t('brands::brand.form.sections.email')" />
          <ITab :title="$t('brands::brand.form.sections.thank_you')" />
          <ITab :title="$t('brands::brand.form.sections.pdf')" />
          <ITab :title="$t('brands::brand.form.sections.signature')" />
        </ITabList>
        <ITabPanels class="px-4 sm:px-6">
          <ITabPanel>
            <IFormGroup class="mb-6" v-if="canChangeDefaultState">
              <IFormCheckbox
                id="is_default"
                name="is_default"
                v-model:checked="form.is_default"
                :label="$t('brands::brand.form.is_default')"
              />
              <IFormError v-text="form.getError('is_default')" />
            </IFormGroup>

            <IFormGroup
              label-for="name"
              :label="$t('brands::brand.form.name')"
              required
            >
              <IFormInput v-model="form.name" id="name" />
              <IFormError v-text="form.getError('name')" />
            </IFormGroup>
            <IFormGroup
              label-for="display_name"
              :label="$t('brands::brand.form.display_name')"
              required
            >
              <IFormInput v-model="form.display_name" id="display_name" />
              <IFormError v-text="form.getError('display_name')" />
            </IFormGroup>
            <IFormGroup :label="$t('brands::brand.form.primary_color')">
              <IColorSwatches
                :allow-remove="false"
                v-model="form.config.primary_color"
                :swatches="swatches"
              />
              <IFormError v-text="form.getError('config.primary_color')" />
            </IFormGroup>

            <IFormGroup class="mt-4">
              <FormVisibilityGroup
                v-model:type="form.visibility_group.type"
                v-model:dependsOn="form.visibility_group.depends_on"
              />
            </IFormGroup>
          </ITabPanel>
          <ITabPanel>
            <IFormGroup
              :label="$t('brands::brand.form.upload_logo')"
              class="mb-5 max-w-xl"
            >
              <CropsAndUploadsImage
                name="logo_view"
                :upload-url="`${$store.state.apiURL}/brands/${brand.id}/logo/view`"
                :image="brand.logo_view_url"
                :show-delete="Boolean(brand.logo_view)"
                :cropper-options="{ aspectRatio: null }"
                :choose-text="
                  !form.logo_view
                    ? $t('core::settings.choose_logo')
                    : $t('core::app.change')
                "
                @cleared="deleteLogo('view')"
                @success="logoUploadedHandler($event, 'view')"
              >
                <template #image="{ src }">
                  <img :src="src" class="h-8 w-auto" />
                </template>
              </CropsAndUploadsImage>
              <p
                class="mt-4 text-sm text-neutral-500 dark:text-neutral-300"
                v-t="'brands::brand.form.navigation.upload_logo_info'"
              />
            </IFormGroup>

            <IFormGroup
              :label="$t('brands::brand.form.navigation.background_color')"
            >
              <IColorSwatches
                :allow-remove="false"
                v-model="form.config.navigation.background_color"
                :swatches="swatches"
              />
              <IFormError
                v-text="form.getError('config.navigation.background_color')"
              />
            </IFormGroup>
          </ITabPanel>
          <ITabPanel>
            <IFormGroup
              :label="$t('brands::brand.form.upload_logo')"
              class="mb-5 max-w-xl"
            >
              <crops-and-uploads-image
                name="logo_mail"
                :upload-url="`${$store.state.apiURL}/brands/${brand.id}/logo/mail`"
                :image="brand.logo_mail_url"
                :show-delete="Boolean(brand.logo_mail)"
                :cropper-options="{ aspectRatio: null }"
                :choose-text="
                  !form.logo_mail
                    ? $t('core::settings.choose_logo')
                    : $t('core::app.change')
                "
                @cleared="deleteLogo('mail')"
                @success="logoUploadedHandler($event, 'mail')"
              >
                <template #image="{ src }">
                  <img :src="src" class="h-8 w-auto" />
                </template>
              </crops-and-uploads-image>
              <p
                class="mt-4 text-sm text-neutral-500 dark:text-neutral-300"
                v-t="'brands::brand.form.email.upload_logo_info'"
              />
            </IFormGroup>

            <h3
              class="mb-4 text-lg font-medium"
              v-t="'brands::brand.form.document.send.info'"
            />

            <IFormGroup
              :label="$t('brands::brand.form.document.send.subject')"
              label-for="document_mail_subject"
            >
              <IFormInput
                v-model="form.config.document.mail_subject"
                id="document_mail_subject"
              />
            </IFormGroup>
            <IFormGroup :label="$t('brands::brand.form.document.send.message')">
              <Editor
                v-model="form.config.document.mail_message"
                :with-image="false"
              />
            </IFormGroup>
            <IFormGroup
              :label="$t('brands::brand.form.document.send.button_text')"
              label-for="document_mail_button_text"
            >
              <IFormInput
                v-model="form.config.document.mail_button_text"
                id="document_mail_button_text"
              />
            </IFormGroup>
            <h3
              class="mb-4 mt-6 text-lg font-medium"
              v-t="'brands::brand.form.document.sign.info'"
            />

            <IFormGroup :label="$t('brands::brand.form.document.sign.subject')">
              <Editor
                v-model="form.config.document.signed_mail_subject"
                :with-image="false"
              />
            </IFormGroup>
            <IFormGroup :label="$t('brands::brand.form.document.sign.message')">
              <Editor
                v-model="form.config.document.signed_mail_message"
                :with-image="false"
              />
            </IFormGroup>
          </ITabPanel>
          <ITabPanel>
            <IFormGroup
              :label="$t('brands::brand.form.document.sign.after_sign_message')"
            >
              <Editor
                v-model="form.config.document.signed_thankyou_message"
                :with-image="false"
              />
            </IFormGroup>
            <IFormGroup
              :label="
                $t('brands::brand.form.document.accept.after_accept_message')
              "
            >
              <Editor
                v-model="form.config.document.accepted_thankyou_message"
                :with-image="false"
              />
            </IFormGroup>
          </ITabPanel>
          <ITabPanel>
            <IFormGroup
              :label="$t('brands::brand.form.pdf.default_font')"
              :description="
                $t('brands::brand.form.pdf.default_font_info', {
                  fontName: 'DejaVu Sans',
                })
              "
              label-for="pdf-font"
              required
            >
              <ICustomSelect
                :clearable="false"
                input-id="pdf-font"
                v-model="form.config.pdf.font"
                :options="fontNames"
              />
              <IFormError v-text="form.getError('config.pdf.font')" />
            </IFormGroup>
            <IFormGroup
              :label="$t('brands::brand.form.pdf.size')"
              label-for="pdf-size"
              required
            >
              <ICustomSelect
                :clearable="false"
                input-id="pdf-size"
                v-model="form.config.pdf.size"
                :options="['a4', 'letter']"
              />
              <IFormError v-text="form.getError('config.pdf.size')" />
            </IFormGroup>
            <IFormGroup
              :label="$t('brands::brand.form.pdf.orientation')"
              label-for="pdf-orientation"
              required
            >
              <ICustomSelect
                :clearable="false"
                input-id="pdf-orientation"
                v-model="form.config.pdf.orientation"
                :options="['portrait', 'landscape']"
              >
                <template #label="{ option }">
                  {{ $t('brands::brand.form.pdf.orientation_' + option) }}
                </template>
                <template #option="option">
                  {{ $t('brands::brand.form.pdf.orientation_' + option.label) }}
                </template>
              </ICustomSelect>
              <IFormError v-text="form.getError('config.pdf.orientation')" />
            </IFormGroup>
          </ITabPanel>
          <ITabPanel>
            <IFormGroup
              :label="$t('brands::brand.form.signature.bound_text')"
              label-for="bound_text"
              required
            >
              <IFormTextarea
                v-model="form.config.signature.bound_text"
                id="bound_text"
              />

              <IFormError
                v-text="form.getError('config.signature.bound_text')"
              />
            </IFormGroup>
          </ITabPanel>
        </ITabPanels>
      </ITabGroup>
    </div>
    <template #footer>
      <IButton
        type="submit"
        :disabled="form.busy"
        :text="$t('core::app.save')"
      />
    </template>
  </ICard>
</template>
<script setup>
import { ref, computed } from 'vue'
import FormVisibilityGroup from '~/Core/resources/js/components/FormVisibilityGroup.vue'
import CropsAndUploadsImage from '~/Core/resources/js/components/CropsAndUploadsImage.vue'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'
import { useBrands } from '../composables/useBrands'
import { useForm } from '~/Core/resources/js/composables/useForm'

const { t } = useI18n()
const route = useRoute()
const { brands, setBrand, fetchBrand, patchBrand } = useBrands()

const componentReady = ref(false)
const brand = ref(null)

const swatches = Innoclapps.config('favourite_colors')
const fonts = Innoclapps.config('contentbuilder.fonts')

const { form } = useForm({
  visibility_group: {
    type: 'all',
    depends_on: [],
  },
})

const fontNames = computed(() => fonts.map(font => font['font-family']))

const canChangeDefaultState = computed(() => {
  // Allow to set as default on the last dashboard which is not default
  if (brands.value.length === 1 && brand.value.is_default === false) {
    return true
  }

  return brands.value.length > 1 && brand.value.is_default === false
})

function prepareComponent(id) {
  fetchBrand(id, {
    params: {
      with: 'visibilityGroup.users;visibilityGroup.teams',
    },
  })
    .then(data => {
      let braindBeingEdited = data

      form.set({
        name: braindBeingEdited.name,
        display_name: braindBeingEdited.display_name,
        config: braindBeingEdited.config,
        is_default: braindBeingEdited.is_default,
      })

      if (braindBeingEdited.visibility_group) {
        form.set('visibility_group', braindBeingEdited.visibility_group)
      }

      brand.value = braindBeingEdited
    })
    .finally(() => (componentReady.value = true))
}

function save() {
  form
    .put(`/brands/${brand.value.id}`, {
      params: {
        with: 'visibilityGroup.users;visibilityGroup.teams',
      },
    })
    .then(updatedBrand => {
      brand.value = updatedBrand
      setBrand(updatedBrand.id, updatedBrand)
      Innoclapps.success(t('brands::brand.updated'))
    })
}

function deleteLogo(type) {
  Innoclapps.request()
    .delete(`/brands/${brand.value.id}/logo/${type}`)
    .then(() => {
      updateCurrentBrandLogo(type, null)
    })
}

function logoUploadedHandler(response, type) {
  // TODO
  // Not reactive, vuejs cannot detect the update for some reason?
  // But that's okay as the user can re-upload new logo if needed without deleting the current
  updateCurrentBrandLogo(type, response.path)
}

function updateCurrentBrandLogo(type, value) {
  brand.value['logo_' + type] = value
  brand.value['logo_' + type + '_url'] = value

  patchBrand(brand.value.id, {
    ['logo_' + type]: value,
    ['logo_' + type + '_url']: value,
  })
}

prepareComponent(route.params.id)
</script>
