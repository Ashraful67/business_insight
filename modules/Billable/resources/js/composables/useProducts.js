/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { ref } from 'vue'
import { createGlobalState } from '@vueuse/core'
import { useLoader } from '~/Core/resources/js/composables/useLoader'

export const useProducts = createGlobalState(() => {
  const {
    setLoading: setLimitedLoading,
    isLoading: limitedNumberOfProductsLoading,
  } = useLoader()

  const limitedNumberOfActiveProducts = ref([])
  const limitedNumberOfActiveProductsRetrieved = ref(false)

  async function fetchProduct(id, options = {}) {
    const { data } = await Innoclapps.request().get(`/products/${id}`, options)
    return data
  }

  async function fetchProductByName(name) {
    const { data } = await Innoclapps.request().get('/products/search', {
      params: {
        q: name,
        search_fields: 'name',
      },
    })

    return data.length > 0 ? data[0] : null
  }

  async function retrieveLimitedNumberOfActiveProducts(limit = 100) {
    if (limitedNumberOfActiveProductsRetrieved.value) {
      return limitedNumberOfActiveProducts.value
    }

    setLimitedLoading(true)

    try {
      const { data } = await fetchActiveProducts({ take: limit })

      limitedNumberOfActiveProducts.value = data

      return data
    } finally {
      setLimitedLoading(false)
      limitedNumberOfActiveProductsRetrieved.value = true
    }
  }

  function fetchActiveProducts(params = {}) {
    return Innoclapps.request().get('/products/active', {
      params: params,
    })
  }

  return {
    limitedNumberOfActiveProducts,
    limitedNumberOfActiveProductsRetrieved,
    limitedNumberOfProductsLoading,

    fetchProduct,
    fetchProductByName,
    retrieveLimitedNumberOfActiveProducts,
    fetchActiveProducts,
  }
})
