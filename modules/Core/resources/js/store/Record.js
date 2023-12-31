/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import ResourceMutations from '@/store/mutations/ResourceMutations'
import ResourceCrud from '@/store/actions/ResourceCrud'

const state = {
  record: {},
}

const mutations = {
  ...ResourceMutations,
}

const actions = {
  ...ResourceCrud,
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
}
