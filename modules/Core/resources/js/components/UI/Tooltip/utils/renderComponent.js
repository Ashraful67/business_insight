/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { createVNode, render } from 'vue'

export default class RenderComponent {
  constructor(options) {
    this.el = options.el
    this.rootComponent = options.rootComponent
    this.props = options?.props ?? {}
    this.appContext = { ...(options?.appContext ?? {}) }
  }

  mount() {
    const componentVNode = createVNode(this.rootComponent, this.props)
    render(componentVNode, this.el)
  }

  unmount() {
    render(null, this.el)
  }
}
