/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
const plugin = require('tailwindcss/plugin')

module.exports = plugin(function ({ addComponents, theme }) {
  const components = {}

  const chartVariants = ['primary', 'warning', 'danger', 'success', 'info']

  chartVariants.forEach(variant => {
    components['.chart-' + variant] = {
      '.ct-point,.ct-line,.ct-bar,.ct-slice-donut': {
        stroke: theme('colors.' + variant + '.500') + ' !important',
      },
      '.ct-slice-pie,.ct-slice-donut-solid,.ct-area': {
        fill: theme('colors.' + variant + '.500') + ' !important',
      },
    }
  })

  components['.ct-label'] = { '@apply dark:text-white': {} }

  components['.chartist-tooltip'] = {
    '@apply !max-w-lg !rounded-md !bg-neutral-800 !text-white !text-center !text-sm':
      {},
    '&:before': {
      display: 'none',
      borderTopColor: theme('colors.white'),
    },
  }

  addComponents(components)
})
