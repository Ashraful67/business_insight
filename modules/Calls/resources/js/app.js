/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import i18n from '~/Core/resources/js/i18n'

import CallsTab from './components/RecordTabCall.vue'
import CallsTabPanel from './components/RecordTabCallPanel.vue'
import RecordTabTimelineCall from './components/RecordTabTimelineCall.vue'

import SettingsCalls from './components/SettingsCalls.vue'

import { useCallOutcomes } from './composables/useCallOutcomes'

const { setCallOutcomes } = useCallOutcomes()

if (window.Innoclapps) {
  Innoclapps.booting((Vue, router) => {
    Vue.component('CallsTab', CallsTab)
    Vue.component('CallsTabPanel', CallsTabPanel)
    Vue.component('RecordTabTimelineCall', RecordTabTimelineCall)

    setCallOutcomes(Innoclapps.config('calls.outcomes') || [])

    router.addRoute('settings', {
      path: 'calls',
      name: 'calls-settings',
      component: SettingsCalls,
      meta: {
        title: i18n.t('calls::call.calls'),
      },
    })
  })
}
