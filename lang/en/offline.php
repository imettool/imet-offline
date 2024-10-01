<?php
return [

    'settings' => [
        'page_title' => 'Settings',

        'proxy' => [
            'title' => 'Proxy',
            'description' => 'This is required only if the your PC is behind a proxy server.',
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
            'protected_planet_api_key_description' => 'This is required to retrieve protected areas from Protected Planet API.',
        ],

        'protected_areas' => [
            'title' => 'Protected Areas',
            'api_description' => 'This is required to retrieve protected areas from Protected Planet API.',
            'last_update' => 'Last update',
            'update' => 'Update',
            'download' => 'Download',
        ],

    ],

];
