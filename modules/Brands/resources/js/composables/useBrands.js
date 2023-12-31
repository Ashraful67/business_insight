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

export const useBrands = createGlobalState(() => {
  const { setLoading, isLoading: brandsAreBeingFetched } = useLoader()

  const brands = ref([])

  const brandsByName = computed(() => orderBy(brands.value, 'name'))

  // Only excuted once
  fetchBrands()

  function idx(id) {
    return brands.value.findIndex(brand => brand.id == id)
  }

  function removeBrand(id) {
    brands.value.splice(idx(id), 1)
  }

  function addBrand(brand) {
    brands.value.push(brand)
  }

  function setBrand(id, brand) {
    brands.value[idx(id)] = brand
  }

  function patchBrand(id, brand) {
    const brandIndex = idx(id)
    brands.value[brandIndex] = Object.assign(brands.value[brandIndex], brand)
  }

  async function fetchBrand(id, options = {}) {
    const { data } = await Innoclapps.request().get(`/brands/${id}`, options)
    return data
  }

  async function deleteBrand(id) {
    await Innoclapps.request().delete(`/brands/${id}`)
    removeBrand(id)
  }

  function fetchBrands() {
    setLoading(true)

    Innoclapps.request()
      .get('/brands')
      .then(({ data }) => (brands.value = data))
      .finally(() => setLoading(false))
  }

  return {
    brands,
    brandsByName,
    brandsAreBeingFetched,

    addBrand,
    removeBrand,
    setBrand,
    patchBrand,

    fetchBrands,
    fetchBrand,
    deleteBrand,
  }
})
