/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

// ##### Import CSS #####
import './index.css';

/* Import packages */
import '@modular-forms/index.js';
import '@imet-core/index.js';

// Global variables - make them accessible from modules and from blade views
window.Laravel = window.Laravel || {};
window.Native = window.Native || {};

// Apps
window.OfflineImet = {}

import SettingsApp from "./js/SettingsApp.js";
window.OfflineImet.SettingsApp = SettingsApp;

import PaUpdate from "./js/PaUpdate.js";
window.OfflineImet.PaUpdate = PaUpdate;

//  #########  test in listen NativePHP events  #########
if(Object.keys(window.Native).length>0){
    window.Native.on("Native\\Laravel\\Events\\Windows\\WindowShown", (payload, event) => {
        console.log('1. WindowShown event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\CheckingForUpdate", (payload, event) => {
        console.log('2. CheckingForUpdate event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\Error", (payload, event) => {
        console.log('3. Error event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\DownloadProgress", (payload, event) => {
        console.log('4. UpdateAvailable event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\UpdateAvailable", (payload, event) => {
        console.log('5. UpdateAvailable event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\UpdateDownloaded", (payload, event) => {
        console.log('6. UpdateDownloaded event received:', payload, event);
    });
    window.Native.on("Native\\Laravel\\Events\\AutoUpdater\\UpdateNotAvailable", (payload, event) => {
        console.log('7. UpdateNotAvailable event received:', payload, event);
    });
}
