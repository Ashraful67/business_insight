/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export default {
  beforeMount: function (el, binding, vnode) {
    el._showModal = () => {
      Innoclapps.$emit('modal-show', binding.value)
    }
    el.addEventListener('click', el._showModal)
  },
  unmounted: function (el, binding, vnode) {
    el.removeEventListener('click', el._showModal)
  },
}
