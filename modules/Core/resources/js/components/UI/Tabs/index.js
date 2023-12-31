/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import ITabGroupComponent from './ITabGroup.vue'
import ITabListComponent from './ITabList.vue'
import ITabComponent from './ITab.vue'
import ITabPanelsComponent from './ITabPanels.vue'
import ITabPanelComponent from './ITabPanel.vue'

const ITabsPlugin = {
  install(app) {
    app.component('ITabGroup', ITabGroupComponent)
    app.component('ITabList', ITabListComponent)
    app.component('ITab', ITabComponent)
    app.component('ITabPanels', ITabPanelsComponent)
    app.component('ITabPanel', ITabPanelComponent)
  },
}

// Components
export const ITabGroup = ITabGroupComponent
export const ITabList = ITabListComponent
export const ITab = ITabComponent
export const ITabPanels = ITabPanelsComponent
export const ITabPanel = ITabPanelComponent

// Plugin
export default ITabsPlugin
