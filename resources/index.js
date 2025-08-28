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

import SpeciesSetupApp from "./js/SpeciesSetupApp.js";
window.OfflineImet.SpeciesSetupApp = SpeciesSetupApp;

import ProtectedPlanetUploadApp from "./js/ProtectedPlanetUploadApp.js";
window.OfflineImet.ProtectedPlanetUploadApp = ProtectedPlanetUploadApp;

import CheckUpdatesApp from "./js/CheckUpdatesApp.js";
window.OfflineImet.CheckUpdatesApp = CheckUpdatesApp;
