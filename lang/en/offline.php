<?php
return [

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

    'errors' => [
        'missing_api_token' => 'Missing API token',
        'generic' => 'Request failed',
    ],

];
