/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
class WindowState {
  constructor() {
    this.hasSupport = 'history' in window && 'pushState' in history
  }
  /**
   * Push in history state
   *
   * @param  {string|null} url
   * @param  {Object|null|string} state
   * @param  {null|string} title
   *
   * @return {void}
   */
  push(url, state = {}, title = null) {
    if (!this.hasSupport) {
      return
    }

    window.history.pushState(state, title, url)
  }

  /**
   * Replace history state
   *
   * @param  {string|null} url
   * @param  {Object|null|string} state
   * @param  {null|string} title
   *
   * @return {void}
   */
  replace(url, state = null, title = null) {
    if (!this.hasSupport) {
      return
    }

    window.history.replaceState(state || window.history.state, title, url)
  }

  /**
   * Clear state hash
   *
   * @param  {String} replaceWith
   *
   * @return {Void}
   */
  clearHash(replaceWith = ' ') {
    return this.replace(replaceWith)
  }
}

export default new WindowState()
