/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { onUnmounted } from 'vue'

export function useGlobalEventListener(eventName, callback) {
  Innoclapps.$on(eventName, callback)

  onUnmounted(() => {
    Innoclapps.$off(eventName, callback)
  })
}
