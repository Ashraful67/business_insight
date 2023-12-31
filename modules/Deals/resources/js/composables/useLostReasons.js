/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { ref, computed } from 'vue'
import orderBy from 'lodash/orderBy'
import { createGlobalState } from '@vueuse/core'
import { useLoader } from '~/Core/resources/js/composables/useLoader'

export const useLostReasons = createGlobalState(() => {
  const { setLoading, isLoading: lostReasonsAreBeingFetched } = useLoader()

  const lostReasons = ref([])

  const lostReasonsByName = computed(() => orderBy(lostReasons.value, 'name'))

  function setLostReasons(list) {
    lostReasons.value = list
  }

  function fetchLostReasons() {
    setLoading(true)

    Innoclapps.request()
      .get('/lost-reasons', {
        params: {
          per_page: 100,
        },
      })
      .then(({ data }) => (lostReasons.value = data.data))
      .finally(() => setLoading(false))
  }

  return {
    lostReasons,
    lostReasonsByName,
    lostReasonsAreBeingFetched,

    setLostReasons,
    fetchLostReasons,
  }
})
