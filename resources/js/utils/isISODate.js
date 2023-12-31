/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import isString from 'lodash/isString'

function isISODate(str) {
  // First perform the checks below, less IQ
  if (!isString(str)) {
    return false
  }

  if (str.indexOf('-') === 1) {
    return false
  }

  // 2020-04-02T03:39:56.000000Z
  return /\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3,6}Z/.test(str)
}

export default isISODate
