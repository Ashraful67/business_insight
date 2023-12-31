/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import isString from 'lodash/isString'

function isStandardDateTime(str) {
  // First perform the checks below, less IQ
  if (!isString(str)) {
    return false
  }

  if (
    str.indexOf('-') <= 1 ||
    str.indexOf(' ') === 0 ||
    str.indexOf(':') === 0
  ) {
    return false
  }

  return /\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(str)
}

export default isStandardDateTime
