/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export default {
  viaResource: String,
  viaResourceId: Number,
  field: { type: Object, required: true },
  isFloating: { type: Boolean, default: false },
  formId: { type: String, required: true },

  view: {
    required: true,
    type: String,
    validator: function (value) {
      return (
        [
          ...Object.keys(Innoclapps.config('fields.views')),
          ...['internal'],
        ].indexOf(value) !== -1
      )
    },
  },
}
