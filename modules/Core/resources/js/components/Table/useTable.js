/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { useStore } from 'vuex'

export function useTable() {
  const store = useStore()

  function reloadTable(tableId) {
    Innoclapps.$emit('reload-resource-table', tableId)
  }

  function customizeTable(tableId, value = true) {
    store.commit('table/SET_CUSTOMIZE_VISIBILTY', {
      id: tableId,
      value: value,
    })
  }

  return { reloadTable, customizeTable }
}
