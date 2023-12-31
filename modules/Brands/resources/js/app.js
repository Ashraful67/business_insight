/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import i18n from '~/Core/resources/js/i18n'

import SettingsBrands from './components/SettingsBrands.vue'
import CreateBrand from './views/CreateBrand.vue'
import EditBrand from './views/EditBrand.vue'

if (window.Innoclapps) {
  Innoclapps.booting(function (Vue, router) {
    router.addRoute('settings', {
      path: '/settings/brands',
      component: SettingsBrands,
      meta: { title: i18n.t('brands::brand.brands') },
    })
    router.addRoute('settings', {
      path: '/settings/brands/create',
      component: CreateBrand,
      name: 'create-brand',
    })
    router.addRoute('settings', {
      path: '/settings/brands/:id/edit',
      component: EditBrand,
      name: 'edit-brand',
    })
  })
}
