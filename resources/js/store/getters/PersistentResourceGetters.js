/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import find from 'lodash/find'

export default {
  getById: state => id => {
    return find(state.collection, ['id', Number(id)])
  },
}
