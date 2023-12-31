/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export default {
  resourceName: { type: String, required: true },
  ids: { type: [Number, String, Array], required: true },
  actionRequestParams: { type: Object, default: () => ({}) },
  actions: { required: true, type: Array, default: () => [] },
  view: {
    default: 'update',
    validator: function (value) {
      return ['update', 'index'].indexOf(value) !== -1
    },
  },
}
