/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import IDropdownComponent from './IDropdown.vue'
import IDropdownItemComponent from './IDropdownItem.vue'
import IDropdownButtonComponent from './IDropdownButton.vue'
import IDropdownButtonGroupComponent from './IDropdownButtonGroup.vue'
import IMinimalDropdownComponent from './IMinimalDropdown.vue'

const IDropdownPlugin = {
  install(app) {
    app.component('IDropdown', IDropdownComponent)
    app.component('IDropdownItem', IDropdownItemComponent)
    app.component('IMinimalDropdown', IMinimalDropdownComponent)
    app.component('IDropdownButton', IDropdownButtonComponent)
    app.component('IDropdownButtonGroup', IDropdownButtonGroupComponent)
  },
}

// Components
export const IDropdown = IDropdownComponent
export const IDropdownItem = IDropdownItemComponent
export const IDropdownButton = IDropdownButtonComponent
export const IDropdownButtonGroup = IDropdownButtonGroupComponent
export const IMinimalDropdown = IMinimalDropdownComponent

// Plugin
export default IDropdownPlugin
