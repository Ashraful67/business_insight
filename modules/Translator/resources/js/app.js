/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import i18n from '~/Core/resources/js/i18n'

import SettingsTranslator from './components/SettingsTranslator.vue'

if (window.Innoclapps) {
  Innoclapps.booting(function (Vue, router) {
    router.addRoute('settings', {
      path: '/settings/translator',
      component: SettingsTranslator,
      meta: { title: i18n.t('translator::translator.translator') },
    })
  })
}
