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

    'please_follow_instructions' => 'Please follow the instructions below',
    'next' => 'Next',

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
        'species' => [
            'title' => 'Species',
            'description' =>
                'This step is required to integrate species data retrieved from the <b>Catalogue of Life</b> into the
                    application. The dataset is required in order to precisely identify species during the assessments.',
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

    'species_info' =>
        'The dataset retrieved from the <b>Catalogue of Life</b> includes all the animal and plant species. Worms, acari,
            insects and other microorganisms are excluded at the moment. The dataset contains the full taxonomy and the
            common names (in multiple languages).',

    'species_instruction' =>
        'In other to integrate the species data into the application, please click on the following button. This process
            may take a few minutes, according to the performance of your device. Please be patient and do not close the application.',

    'citation' => 'Citation',

    'protected_planet_citation' =>
        'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World Database
            on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge, UK: UNEP-WCMC
            and IUCN. Available at: <a target="_blank" href="https://protectedplanet.net/">www.protectedplanet.net.</a>',

    'protected_planet_instructions' => [
        'browse' => 'Browse to the <span class="highlight">Protected Planet</span> website (<span class="highlight">www.protectedplanet.net</span>)',
        'download' => 'Locate the <span class="highlight">Downloads</span> section and download one of the following
            datasets (according to your needs):' .
            '<ul>' .
            '<li><span class="highlight">WDPA_Aug2025_Public_csv</span>: contains all the Protected Areas</li>' .
            '<li><span class="highlight">WDOECM_Aug2025_Public_csv</span>: contains all the OECMs</li>' .
            '<li><span class="highlight">WDPA_WDOECM_Aug2025_Public_all_csv</span>: contains all the Protected Areas and OECMs</li>' .
            '</ul>',
        'upload' => 'Select the downloaded file, using the following field',
        'apply' => 'Store the dataset in the application by clicking on the following button.',
        'completed' => 'The dataset is stored in the application. You can now proceed.',
    ]

];
