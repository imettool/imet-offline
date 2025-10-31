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

    'page_title' => 'Configuración',

    'proxy' => [
        'title' => 'Proxy',
        'info' => 'Esto sólo es necesario si su PC está detrás de un servidor proxy.',
        'fields' => [
            'proxy_host' => 'Host',
            'proxy_port' => 'Puerto',
            'proxy_user' => 'Usuario',
            'proxy_password' => 'Contraseña',
        ]
    ],

    'user' => [
        'title' => 'Información personal',
    ],

    'wdpas' => [
        'info' => 'Con el siguiente procedimiento es posible actualizar <b>la Base de Datos Mundial de Áreas Protegidas
                    (WDPA)</b> y <b>la Base de Datos Mundial sobre Otras Medidas Efectivas basadas en Áreas de Conservación
                    (WD-OECM)</b> integradas en la aplicación.
                    Los conjuntos de datos son necesarios para crear nuevas evaluaciones y asociarlas con el Área Protegida
                    o OECM correcta.'
    ],

];

