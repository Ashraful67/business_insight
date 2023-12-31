/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import routes from './routes'

import RecordStore from './store/Record'
import FieldsStore from './store/Fields'
import TableStore from './store/Table'
import FiltersStore from './store/Filters'
import RecordPreviewStore from './store/RecordPreview'

if (window.Innoclapps) {
  Innoclapps.booting(function (Vue, router, store) {
    store.registerModule('record', RecordStore)
    store.registerModule('fields', FieldsStore)
    store.registerModule('table', TableStore)
    store.registerModule('filters', FiltersStore)
    store.registerModule('recordPreview', RecordPreviewStore)

    // Routes
    routes.forEach(route => router.addRoute(route))
  })
}
