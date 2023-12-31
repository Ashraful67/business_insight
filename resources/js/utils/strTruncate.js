/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
function strTruncate(text, length, suffix = '...') {
  return text.substring(0, length) + suffix
}

export default strTruncate
