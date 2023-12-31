/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
function getLocale(fallback = 'en') {
  // Check if defined, e.q. in layout auth is not defined yet @todo, define locale, perhaps from session
  if (typeof config !== 'undefined') {
    return config.locale || config.fallback_locale || fallback
  } else if (typeof window !== 'undefined') {
    const { userLanguage, language } = window.navigator
    return (userLanguage || language).substr(0, 2)
  }

  return fallback
}

export default getLocale
