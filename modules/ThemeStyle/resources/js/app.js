/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import i18n from '~/Core/resources/js/i18n'

import SettingsThemeStyle from './components/SettingsThemeStyle.vue'

if (window.Innoclapps) {
  Innoclapps.booting(function (Vue, router) {
    router.addRoute('settings', {
      path: '/settings/theme-style',
      component: SettingsThemeStyle,
      meta: { title: i18n.t('themestyle::style.theme_style') },
    })
  })
}
