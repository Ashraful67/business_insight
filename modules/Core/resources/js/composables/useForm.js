/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { reactive } from 'vue'
import Form from '~/Core/resources/js/services/Form/Form'

export function useForm(data = {}, options = {}) {
  const form = reactive(new Form(data, options))

  return { form }
}
