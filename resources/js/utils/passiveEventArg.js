/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
/**
 * Get the passive third arguemtn and check whether the browser supports it
 *
 * @return {Boolen|Object}
 */
function passiveEventArg() {
  // Cache checks
  if (window.hasOwnProperty('__passiveEvt')) {
    return window.__passiveEvt
  }

  let result = false

  try {
    const arg = Object.defineProperty({}, 'passive', {
      get() {
        result = {
          passive: true,
        }
        return true
      },
    })

    window.addEventListener('testpassive', arg, arg)
    window.remove('testpassive', arg, arg)
  } catch (e) {
    /* */
  }

  window.__passiveEvt = result

  return result
}

export default passiveEventArg
