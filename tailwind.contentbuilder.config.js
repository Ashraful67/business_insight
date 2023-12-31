/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')
const utils = require('./resources/js/tailwindcss/utils')

module.exports = {
  content: [],

  safelist: [],

  darkMode: 'class', // or 'media' or 'class'

  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
    },

    colors: {
      transparent: 'transparent',
      current: 'currentColor',

      black: colors.black,
      white: colors.white,

      neutral: utils.generateColorVariant('neutral'),
      danger: utils.generateColorVariant('danger'),
      warning: utils.generateColorVariant('warning'),
      success: utils.generateColorVariant('success'),
      info: utils.generateColorVariant('info'),
      primary: utils.generateColorVariant('primary'),
    },
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  },
}
