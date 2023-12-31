/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import { useApp } from '~/Core/resources/js/composables/useApp'

export function useSignature() {
  const { currentUser } = useApp()

  function addSignature(message = '') {
    return (
      message +
      (currentUser.value.mail_signature
        ? '<br /><br />----------<br />' + currentUser.value.mail_signature
        : '')
    )
  }

  return {
    addSignature,
  }
}
