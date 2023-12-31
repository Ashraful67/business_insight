/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import IConfirmationDialogComponent from './IConfirmationDialog.vue'
import IModalComponent from './IModal.vue'
import ISlideoverComponent from './ISlideover.vue'

const IDialogPlugin = {
  install(app, options = {}) {
    app.component('IConfirmationDialog', IConfirmationDialogComponent)
    app.component('IModal', IModalComponent)
    app.component('ISlideover', ISlideoverComponent)

    app.config.globalProperties.$iModal = {
      hide(id) {
        options.globalEmitter.$emit('modal-hide', id)
      },
      show(id) {
        options.globalEmitter.$emit('modal-show', id)
      },
    }
  },
}

// Components
export const IConfirmationDialog = IConfirmationDialogComponent
export const IModal = IModalComponent
export const ISlideover = ISlideoverComponent

// Plugin
export default IDialogPlugin
