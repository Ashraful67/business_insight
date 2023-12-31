/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')
const utils = require('./resources/js/tailwindcss/utils')

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './modules/**/resources/js/**/*.vue',
    './modules/**/resources/**/*.blade.php',
    './public/assets/contentbuilder/contentbuilder/plugins/*.js',
  ],

  safelist: [
    // Highlights
    'bg-warning-500',
    'bg-info-500',
    // Fields cols width
    'col-span-12',
    'sm:col-span-6',
    // Cards cols width
    'w-full',
    'lg:w-1/2',
    // Coolean column centering
    'text-center',
    // Webhook workflow action attributes
    '!pl-16',
    // TinyMCE
    'tox-tinymce',
    'tox',
    // Chartist
    'chartist-tooltip',
    'ct-label',
    // https://tailwindcss.com/docs/content-configuration#safelisting-classes
    {
      pattern: /^chart-.*/,
    },
    {
      pattern: /^ct-.*/,
    },
  ],

  darkMode: 'class', // or 'media' or 'class'

  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        signature: ['Dancing Script', 'cursive'],
      },
      height: {
        navbar: 'var(--navbar-height)',
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
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar')({ nocompatible: true }),
    require('./resources/js/tailwindcss/plugins/all'),
    require('./resources/js/tailwindcss/plugins/tinymce'),
    require('./resources/js/tailwindcss/plugins/chartist'),
    require('./resources/js/tailwindcss/plugins/mail'),
  ],
}
