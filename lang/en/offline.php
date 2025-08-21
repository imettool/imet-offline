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

    'setup' => [

        'description' =>
            'Welcome to the <b>IMET Offline Tool</b>!<br> This is the first time you are using the application and simple setup
                is required to get started.',

        'offline_warning' =>
            'The IMET Offline Tool is designed to be used in the field, where internet connectivity may be limited or unavailable
            but during the setup process <b>an internet connection is required</b>. Please ensure that you are connected to the internet before proceeding with the setup.',

        'timeline' => [
            'info' => [
                'title' => 'Start setup',
            ],
            'user' => [
                'title' => 'User profile',
                'description' =>
                    'Please provide your personal information. This information will remain private and stored locally.
                    However, the information will be associated with any assessments created or modified with this software;
                    exporting and sharing the assessment therefore implies sharing this information as well.'
            ],
            'wdpas' => [
                'title' => 'Protected Areas and OECMs',
                'description' =>
                    'This step is required to integrate <b>The World Database on Protected Areas (WDPA)</b> and <b>The
                    World Database on Other Effective Area-based Conservation Measures (WD-OECM)</b> in the application.
                    The datasets are required in order to create new assessments and to associate them with the correct
                    Protected Area or OECM. <br />Please note that this step requires an internet connection.',
            ],
            'done' => [
                'title' => 'Setup completed !',
                'description' =>
                    'The setup is completed. You can now start using the application.',
            ],
        ],

        'citation' => 'Citation',

        'protected_planet_citation' =>
            'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World Database
            on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge, UK: UNEP-WCMC
            and IUCN. Available at: <a target="_blank" href="http://protectedplanet.net/">www.protectedplanet.net.</a>',

        'protected_planet_instructions' => [
            'browse' => 'Browse to the <span class="highlight">Protected Planet</span> website (<span class="highlight">www.protectedplanet.net</span>)',
            'locate' => 'Locate and open the <span class="highlight">Downloads</span> banner',
            'download' => 'Download one of the following datasets (according to your needs):' .
                '<ul>' .
                '<li><span class="highlight">WDPA_Aug2025_Public_csv</span>: contains all the Protected Areas</li>' .
                '<li><span class="highlight">WDOECM_Aug2025_Public_csv</span>: contains all the OECMs</li>' .
                '<li><span class="highlight">WDPA_WDOECM_Aug2025_Public_all_csv</span>: contains all the Protected Areas and OECMs</li>' .
                '</ul>',
            'upload' => 'Using the following field, pick the downloaded file.',
            'apply' => 'Store the dataset in the application by clicking on the following button.',
        ],

    ],

    'settings' => [
        'page_title' => 'Settings',

        'proxy' => [
            'title' => 'Proxy',
            'info' => 'This is required only if the your PC is behind a proxy server.',
            'fields' => [
                'proxy_host' => 'Host',
                'proxy_port' => 'Port',
                'proxy_user' => 'User',
                'proxy_password' => 'Password',
            ]
        ],

        'user' => [
            'title' => 'User profile',
        ],

        'api_keys' => [
            'title' => 'API keys',
            'fields' => [
                'protected_planet_api_key' => 'Protected Planet API',
            ],
            'protected_planet_api_key_description' => '<b>Required</b> to retrieve protected areas from Protected Planet API. Request a key <a href="https://api.protectedplanet.net/" target="_blank">here</a>',
        ],

        'protected_areas' => [
            'title' => 'Protected Areas',
            'info' => 'A <b>Protected Planet API key</b> is required to retrieve protected areas from Protected Planet API.',
            'api_description' => 'This is required to retrieve protected areas from Protected Planet API.',
            'last_update' => 'Last update',
            'update' => 'Update',
            'download' => 'Download',
        ],

    ],

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

    'errors' => [
        'missing_api_token' => 'Missing API token',
        'generic' => 'Request failed',
    ],

];
