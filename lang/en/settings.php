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

    'page_title' => 'Settings',

    'proxy' => [
        'title' => 'Proxy',
        'info' => 'This is required only if the your PC is behind a proxy server.',
        'fields' => [
            'proxy_host' => 'Host',
            'proxy_port' => 'Port',
            'proxy_user' => 'User',
            'proxy_password' => 'Password',
        ],
    ],

    'user' => [
        'title' => 'Personal information',
    ],

    'wdpas' => [
        'info' => 'With the following procedure it is possible to update <b>The World Database on Protected Areas (WDPA)</b>
                    and <b>The World Database on Other Effective Area-based Conservation Measures (WD-OECM)</b> integrated
                    into the application.
                    The datasets are required in order to create new assessments and to associate them with the correct
                    Protected Area or OECM.',
    ],

];
