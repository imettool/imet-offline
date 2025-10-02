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
        'title' => 'Personal information',
    ],

    'wdpas' => [
        'info' => 'With the following procedure it is possible to update <b>The World Database on Protected Areas (WDPA)</b>
                    and <b>The World Database on Other Effective Area-based Conservation Measures (WD-OECM)</b> integrated
                    into the application.
                    The datasets are required in order to create new assessments and to associate them with the correct
                    Protected Area or OECM.'
    ],

];
