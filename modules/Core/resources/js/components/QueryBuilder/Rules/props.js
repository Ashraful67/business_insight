/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export default {
  operand: { required: true },
  isNullable: { required: true, type: Boolean },
  index: { required: true, type: Number },
  query: { type: Object, required: false },
  rule: { type: Object, required: true },
  labels: { required: true },
  operator: { required: true },
  isBetween: { default: false, type: Boolean },
  readOnly: { default: false, type: Boolean },
}
