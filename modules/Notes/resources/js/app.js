/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import NotesTab from './components/RecordTabNote.vue'
import NotesTabPanel from './components/RecordTabNotePanel.vue'
import RecordTabTimelineNote from './components/RecordTabTimelineNote.vue'

if (window.Innoclapps) {
  Innoclapps.booting((Vue, router) => {
    Vue.component('NotesTab', NotesTab)
    Vue.component('NotesTabPanel', NotesTabPanel)
    Vue.component('RecordTabTimelineNote', RecordTabTimelineNote)
  })
}
