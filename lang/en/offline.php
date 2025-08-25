<?php
/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

return [

    'title' => 'IMET Offline Tool',
    'version' => 'Version',
    'description' =>
        '<b>IMET</b> is a <i>Protected Area Management Effectiveness (PAME)</i> tool that allows an in-depth assessment of marine and
        terrestrial protected areas, regardless of their management categories and governance type. As a decision-support
        tool, it helps protected area managers take analysis-based management decisions for improved conservation outcomes.',

    'update' => [

        'no_new_version' => 'No new version available',
        'new_version_available' => 'New version available!',
        'update_to_latest' => 'Update to latest version',
        'release_notes' => 'Release notes',
        'release_date' => 'Release date',
        'current_version' => 'Current version',
        'latest_version' => 'Latest version',
        'update_now' => 'Update now',
        'update_later' => 'Update later',
        'require_installation' => 'This update requires an complete re-installation of the software. Please download the installer below. <br /> Backup your IMET assessments before proceeding with the installation.',
        'download_installer' => 'Download installer',
        'downloading' => 'Downloading',
        'download_successful' => 'New version downloaded successfully',
        'download_successful_long' =>
            'New version downloaded successfully.  <br /> Please close completely the application and launch it again
            to apply the updates.',
        'cannot_switch_to_stable' => 'Cannot switch to stable channel',
        'cannot_switch_to_stable_long' =>
            'You cannot switch back to stable channel from the current BETA version. <br /> Some modifications may have
            been applied to the database that are not compatible with the stable version. You will be able to switch back
            to the stable channel when a new stable version, which includes these modifications, is released.',

    ],

    'actions' => [
        'proceed' => 'Proceed',
    ],

    'errors' => [
        'missing_api_token' => 'Missing API token',
        'generic' => 'Request failed',
    ],

];
