/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
function isValueEmpty(value) {
  // Perform checks for all data types
  // https://javascript.info/types
  if (value !== null && typeof value !== 'undefined') {
    if (typeof value === 'string' && value !== '') {
      return false
    } else if (typeof value === 'array' && value.length > 0) {
      return false
    } else if (typeof value === 'object' && Object.keys(value).length > 0) {
      return false
    } else if (typeof value === 'boolean' || typeof value === 'number') {
      return false
    }
  }

  return true
}

export default isValueEmpty
