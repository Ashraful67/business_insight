/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import htmlInputProps from './htmlInputProps'
export default {
  modelValue: [String, Number],
  autocomplete: String,
  maxlength: [String, Number],
  minlength: [String, Number],
  pattern: String,
  placeholder: String,
  ...htmlInputProps,
}
