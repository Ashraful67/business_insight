/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import IButtonComponent from './IButton.vue'
import IButtonCloseComponent from './IButtonClose.vue'
import IButtonCopyComponent from './IButtonCopy.vue'
import IButtonGroupComponent from './IButtonGroup.vue'
import IButtonIconComponent from './IButtonIcon.vue'
import IButtonMinimalComponent from './IButtonMinimal.vue'

const IButtonPlugin = {
  install(app) {
    app.component('IButton', IButtonComponent)
    app.component('IButtonClose', IButtonCloseComponent)
    app.component('IButtonMinimal', IButtonMinimalComponent)
    app.component('IButtonCopy', IButtonCopyComponent)
    app.component('IButtonIcon', IButtonIconComponent)
    app.component('IButtonGroup', IButtonGroupComponent)
  },
}

// Components
export const IButton = IButtonComponent
export const IButtonClose = IButtonCloseComponent
export const IButtonCopy = IButtonCopyComponent
export const IButtonGroup = IButtonGroupComponent
export const IButtonIcon = IButtonIconComponent
export const IButtonMinimal = IButtonMinimalComponent

// Plugin
export default IButtonPlugin
