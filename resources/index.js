// ##### Import CSS #####
import './index.css';

/* Import packages */
import '@modular-forms/index.js';
import '@imet-core/index.js';

// Global variables - make them accessible from modules and from blade views
window.Laravel = window.Laravel || {};

// Apps
window.OfflineImet = {}

import SettingsApp from "./js/SettingsApp.js";
window.OfflineImet.SettingsApp = SettingsApp;

import PaUpdate from "./js/PaUpdate.js";
window.OfflineImet.PaUpdate = PaUpdate;
