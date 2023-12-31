/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import moment from 'moment-timezone'

// import other locales as they are added
import 'moment/dist/locale/pt-br'
import 'moment/dist/locale/es'

import momentPhp from './momentPhp'
import { getLocale } from '@/utils'

moment.locale(getLocale().replace('_', '-'))

momentPhp(moment)

window.moment = moment
