/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import CommentsStore from './store/Comments'

if (window.Innoclapps) {
  Innoclapps.booting(function (Vue, router, store) {
    store.registerModule('comments', CommentsStore)
  })
}
