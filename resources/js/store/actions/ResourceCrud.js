/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export default {
  /**
   * Fetch records from storage
   *
   * @param  {Function} options.commit
   * @param  {Object} options.state
   * @param  {Object} options
   *
   * @return {Array}
   */
  async fetch({ state }, options = {}) {
    let { data: records } = await Innoclapps.request().get(
      options.endpoint ? options.endpoint : state.endpoint,
      options
    )

    return records
  },

  /**
   * Get single record from database
   *
   * @param  {Function} options.commit
   * @param  {Object} options.state
   * @param  {Number|Object} options
   *
   * @return {Object}
   */
  async get({ state }, options) {
    const id = typeof options === 'object' ? options.id : options
    const queryString = typeof options === 'object' ? options.queryString : {}

    let { data: records } = await Innoclapps.request().get(
      `${state.endpoint}/${id}`,
      {
        params: queryString,
      }
    )

    return records
  },

  /**
   * Store a record
   *
   * @param  {Function} options.commit
   * @param  {Object} options.state
   * @param  {Object} form
   *
   * @return {Object}
   */
  async store({ state }, form) {
    let record = await form.post(state.endpoint)

    return record
  },

  /**
   * Update a record
   *
   * @param  {Function} options.commit
   * @param  {Object} options.state
   * @param  {Object} payload
   *
   * @return {Object}
   */
  async update({ state }, payload) {
    let record = await payload.form.put(`${state.endpoint}/${payload.id}`, {
      params: payload.queryString || {},
    })

    return record
  },

  /**
   * Delete a record
   *
   * @param  {Function} options.commit
   * @param  {Object} options.state
   * @param  {Number} id
   *
   * @return {mixed}
   */
  async destroy({ state }, id) {
    await Innoclapps.dialog().confirm()

    let { data } = await Innoclapps.request().delete(`${state.endpoint}/${id}`)

    return data
  },
}
