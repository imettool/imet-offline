/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

// ##### Import CSS #####
import './index.css';

/* Import packages */
import '@modular-forms/index.js';
import '@imet-core/index.js';

// Global variables - make them accessible from modules and from blade views
window.Laravel = window.Laravel || {};

// Apps
window.OfflineImet = {}

import UserProfileApp from "./js/UserProfileApp.js";
window.OfflineImet.UserProfileApp = UserProfileApp;

import SpeciesSetupApp from "./js/SpeciesSetupApp.js";
window.OfflineImet.SpeciesSetupApp = SpeciesSetupApp;

import ProtectedPlanetUploadApp from "./js/ProtectedPlanetUploadApp.js";
window.OfflineImet.ProtectedPlanetUploadApp = ProtectedPlanetUploadApp;

import CheckUpdatesApp from "./js/CheckUpdatesApp.js";
window.OfflineImet.CheckUpdatesApp = CheckUpdatesApp;

import HotKeysApp from "./js/HotKeysApp.js";
window.OfflineImet.HotKeysApp = HotKeysApp;
