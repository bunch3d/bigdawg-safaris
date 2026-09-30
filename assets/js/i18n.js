/* ==========================================================================
   I18N.JS
   Client-side multi-language swap. This is a COMFORT feature only, per
   project decision: it changes what the visitor sees, but pages are not
   separately indexed per language for SEO. If that changes later, this
   would need to become server-side (PHP) language routing instead.

   How it works:
   1. Every translatable element in the HTML has a data-i18n="key" attribute.
   2. assets/lang/<code>.json holds { "key": "translated text" } pairs.
   3. On load (and whenever the <select> changes), we fetch the right JSON
      file and replace each tagged element's text.
   4. The chosen language is remembered in localStorage so it persists
      across pages/visits.

   To add a new fully-translated language: create assets/lang/<code>.json
   with the same keys as en.json — no other file needs to change.
   ========================================================================== */

var I18N_STORAGE_KEY = 'bigdawg_lang';
var I18N_DEFAULT_LANG = 'en';

document.addEventListener('DOMContentLoaded', function () {
  var select = document.getElementById('langSelect');
  var savedLang = localStorage.getItem(I18N_STORAGE_KEY) || I18N_DEFAULT_LANG;

  if (select) {
    select.value = savedLang;
    select.addEventListener('change', function () {
      var chosen = select.value;
      localStorage.setItem(I18N_STORAGE_KEY, chosen);
      loadLanguage(chosen);
    });
  }

  // Only load a language on init if it isn't the default — avoids an
  // unnecessary fetch for English visitors, since the page already
  // ships with English text baked into the HTML.
  if (savedLang !== I18N_DEFAULT_LANG) {
    loadLanguage(savedLang);
  }
});

/**
 * loadLanguage(langCode)
 * Fetches the translation file for the given language and applies it.
 * Falls back silently to English (i.e. leaves the baked-in HTML text
 * alone) if the file is missing — so an incomplete language (say,
 * Italian not translated yet) never breaks the page, it just shows
 * English for now.
 */
function loadLanguage(langCode) {
  fetch('assets/lang/' + langCode + '.json')
    .then(function (response) {
      if (!response.ok) throw new Error('Translation file not found: ' + langCode);
      return response.json();
    })
    .then(function (translations) {
      applyTranslations(translations);
    })
    .catch(function (err) {
      console.warn('[i18n] Falling back to English —', err.message);
    });
}

/**
 * applyTranslations(dict)
 * Walks every [data-i18n] element on the page and swaps its text
 * content for the matching dictionary entry, if one exists.
 */
function applyTranslations(dict) {
  document.querySelectorAll('[data-i18n]').forEach(function (el) {
    var key = el.getAttribute('data-i18n');
    if (Object.prototype.hasOwnProperty.call(dict, key)) {
      el.textContent = dict[key];
    }
  });
}
