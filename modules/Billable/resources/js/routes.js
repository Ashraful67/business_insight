/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import i18n from '~/Core/resources/js/i18n'

import ProductIndex from './views/ProductIndex.vue'
import CreateProduct from './views/CreateProduct.vue'
import EditProduct from './views/EditProduct.vue'

export default [
  {
    path: '/products',
    name: 'product-index',
    component: ProductIndex,
    meta: {
      title: i18n.t('billable::product.products'),
    },
    children: [
      {
        path: 'create',
        name: 'create-product',
        component: CreateProduct,
        meta: { title: i18n.t('billable::product.create') },
      },
      {
        path: ':id',
        name: 'view-product',
        component: EditProduct,
      },
      {
        path: ':id/edit',
        name: 'edit-product',
        component: EditProduct,
      },
    ],
  },
]
