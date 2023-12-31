/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export function useVoip() {
  const voip = Innoclapps.app.config.globalProperties.$voip

  const hasVoIPClient = Innoclapps.config('voip.client') !== null

  return { voip, hasVoIPClient }
}
