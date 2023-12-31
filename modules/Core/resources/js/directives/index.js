/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import Modal from './modal'
import Toggle from './toggle'

function registerDirectives(app) {
  app.directive('i-modal', Modal)
  app.directive('i-toggle', Toggle)
}

export default registerDirectives
export { Modal, Toggle }
