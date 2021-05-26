// Utilities & frameworks
window.$ = window.jQuery = require('jquery'); // already imported in modular-forms but give error if not required also here

require('bootstrap');
require('bootstrap-select');
require('bootstrap-datepicker');

require('select2');
require('select2/dist/js/i18n/fr');
window.$.fn.select2.defaults.set("theme", "bootstrap");
window.$.fn.select2.defaults.set("language", Lang.getLocale());

window.echarts = require('echarts');
