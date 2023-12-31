/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import map from 'lodash/map'
import find from 'lodash/find'

export function useCards() {
  function applyUserConfig(cards, dashboard) {
    return map(cards, (card, index) => {
      let config = find(dashboard.cards, ['key', card.uriKey])

      card.order = config
        ? config.hasOwnProperty('order')
          ? config.order
          : index + 1
        : index + 1

      card.enabled =
        !config || config.enabled || typeof config.enabled == 'undefined'
          ? true
          : false

      return card
    })
  }

  return { applyUserConfig }
}
