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

    'setup' => 'Setup',
    'please_follow_instructions' => 'Please follow the instructions below',
    'next' => 'Next',
    'citation' => 'Citation',

    'timeline' => [

    ],

    'info' => [
        'timeline' => 'Start setup',
        'description' => 'Welcome to the <b>IMET Offline Tool</b>!<br> This is the first time you are using the application
                and a quick setup is required to get started.',
        'offline_warning' => 'The IMET Offline Tool is designed to be used in the field, where internet connectivity may
                be limited or unavailable but during this setup process <b>an internet connection is required</b>. Please
                ensure that you are connected to the internet before proceeding with the setup.',
    ],

    'user' => [
        'timeline' => 'Personal Information',
        'info' => '<div>The provided information will remain private and stored locally. However, the information will be
                    associated with any assessments created or modified with this software; exporting and sharing the
                    assessment therefore implies sharing the information as well.</div>',
    ],

    'species' => [
        'timeline' => 'Species',
        'info' => '<div>This step is required to integrate species data retrieved from the <b>Catalogue of Life</b> into the
                    application. The dataset is required in order to precisely identify species during the assessments.</div>
                    <div>The dataset retrieved includes all animal and plant species. Worms, acari, insects and other
                    microorganisms are excluded at the moment. The dataset contains the full taxonomy and the common
                    names (in multiple languages).</div>',
        'citation' => 'Bánki, O., Roskov, Y., Döring, M., Ower, G., Hernández Robles, D. R., Plata Corredor, C. A.,
                    Stjernegaard Jeppesen, T., Örn, A., Pape, T., Hobern, D., Garnett, S., Little, H., DeWalt, R. E., Miller,
                    J., Orrell, T., Aalbu, R., Abbott, J., Aedo, C., Aescht, E., et al. (2025). <b>Catalogue of Life </b>
                    (Version 2025-09-11). Catalogue of Life Foundation, Amsterdam, Netherlands.
                    <a target="_blank" href="https://doi.org/10.48580/dgt98">https://doi.org/10.48580/dgt98</a>',
        'instructions' => 'In other to integrate the species data into the application, please click on the following
                    button. This process may take a few minutes, according to the performance of your device. Please be
                    patient and do not close the application.',
    ],

    'wdpas' => [
        'timeline' => 'Protected Areas and OECMs',
        'info' => 'This step is required to integrate <b>The World Database on Protected Areas (WDPA)</b> and <b>The
                    World Database on Other Effective Area-based Conservation Measures (WD-OECM)</b> in the application.
                    The datasets are required in order to create new assessments and to associate them with the correct
                    Protected Area or OECM.',
        'warning' => 'Please note that the process requires an internet connection.',
        'citation' => 'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World
                    Database on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge,
                    UK: UNEP-WCMC and IUCN. Available at:
                    <a target="_blank" href="https://protectedplanet.net/">www.protectedplanet.net.</a>',
        'instructions' => [
            'browse' => 'Browse to the <span class="highlight">Protected Planet</span> website
                        (<span class="highlight">www.protectedplanet.net</span>)',
            'navigate' => 'Click on the <span class="highlight">Explore protected areas and OECMs</span> button',
            'download' => 'Locate the <span class="highlight mr-0.5">Download</span> button and proceed with the download of the
                        <span class="highlight mr-0.5">CSV</span> file. <br />A <span class="highlight mr-0.5">ZIP</span>
                        archive will be downloaded: it is <b>not necessary</b> to extract it.',
            'upload' => 'Click on the following <span class="highlight mr-0.5">Upload file</span> button and select the
                        downloaded <span class="highlight mr-0.5">ZIP</span> file',
            'apply' => 'Start the integration of the dataset into the application by clicking on the following button.',
            'completed' => 'The dataset is stored in the application.',
            'update' => 'If you want to update the dataset in the future, you can repeat the same procedure at any time
                        from the <span class="highlight">Settings</span> page.',
            'next' => 'You can now proceed to the next step.',
        ],
    ],

    'done' => [
        'timeline' => 'Setup completed !',
        'description' => 'The setup is completed. You can now start using the application.',
    ],

];
