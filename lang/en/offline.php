<?php
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

return [

    'title' => 'IMET Offline Tool',
    'version' => 'Version',
    'description' =>
        '<b>IMET</b> is a <i>Protected Area Management Effectiveness (PAME)</i> tool that allows an in-depth assessment of marine and
        terrestrial protected areas, regardless of their management categories and governance type. As a decision-support
        tool, it helps protected area managers take analysis-based management decisions for improved conservation outcomes.',

    'update' => [

        'checking' => 'Checking for updates...',
        'available' => 'New version available',
        'not_available' => 'You are using the latest version.',
        'downloading' => 'Downloading new version...',
        'downloaded' => 'New version downloaded successfully.',
        'cancelled' => 'Update cancelled.',
        'error' => 'Error occurred while retrieving update',

    ],

    'actions' => [
        'proceed' => 'Proceed',
    ],

    'errors' => [
        'missing_api_token' => 'Missing API token',
        'generic' => 'Request failed',
    ],

];
