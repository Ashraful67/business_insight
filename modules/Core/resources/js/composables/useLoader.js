/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { ref } from 'vue'

export function useLoader(defaultValue = false) {
  const isLoading = ref(defaultValue)

  function setLoading(value = true) {
    isLoading.value = value
  }

  return { setLoading, isLoading }
}
