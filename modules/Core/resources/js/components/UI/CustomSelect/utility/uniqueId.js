/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
let idCount = 0

/**
 * Dead simple unique ID implementation.
 * Thanks lodash!
 * @return {number}
 */
function uniqueId() {
  return ++idCount
}

export default uniqueId
