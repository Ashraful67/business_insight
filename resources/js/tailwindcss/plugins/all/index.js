/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
const plugin = require('tailwindcss/plugin')

module.exports = plugin(function ({ addUtilities }) {
  addUtilities({
    '.all-initial': { all: 'initial' },
    '.all-inherit': { all: 'inherit' },
    '.all-revert': { all: 'revert' },
    '.all-unset': { all: 'unset' },
  })
})
