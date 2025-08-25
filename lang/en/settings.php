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
];
