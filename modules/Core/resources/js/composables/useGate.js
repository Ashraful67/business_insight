/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export function useGate() {
  const gate = Innoclapps.app.config.globalProperties.$gate

  return { gate }
}
