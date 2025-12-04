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

    'page_title' => 'Configurações',

    'proxy' => [
        'title' => 'Proxy',
        'info' => 'Isto é necessário apenas se o seu PC estiver atrás de um servidor proxy.',
        'fields' => [
            'proxy_host' => 'Host',
            'proxy_port' => 'Porta',
            'proxy_user' => 'Usuário',
            'proxy_password' => 'Senha',
        ],
    ],

    'user' => [
        'title' => 'Informações pessoais',
    ],

    'wdpas' => [
        'info' => 'Com o seguinte procedimento é possível atualizar <b>o Banco de Dados Mundial de Áreas Protegidas
                    (WDPA)</b> e <b>o Banco de Dados Mundial sobre Outras Medidas de Conservação Efetivas baseadas em
                    Áreas (WD-OECM)</b> integrados na aplicação.
                    Os conjuntos de dados são necessários para criar novas avaliações e associá-las à Área Protegida ou
                    OECM correta.',
    ],

];
