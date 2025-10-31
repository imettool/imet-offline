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

    'setup' => 'Configuración',
    'please_follow_instructions' => 'Por favor, siga las instrucciones a continuación',
    'next' => 'Siguiente',
    'citation' => 'Cita',

    'timeline' => [

    ],

    'info' => [
        'timeline' => 'Iniciar configuración',
        'description' => '¡Bienvenido a la <b>Herramienta IMET sin conexión</b>!<br> Esta es la primera vez que utiliza
                la aplicación y se requiere una configuración rápida para comenzar.',
        'offline_warning' => 'La Herramienta IMET sin conexión está diseñada para usarse en el campo, donde la conectividad
                a Internet puede ser limitada o inexistente, pero durante este proceso de configuración <b>se requiere
                una conexión a Internet</b>. Por favor, asegúrese de estar conectado a Internet antes de continuar con la
                configuración.',
    ],

    'user' => [
        'timeline' => 'Información personal',
        'info' => '<div>La información proporcionada permanecerá privada y se almacenará localmente. Sin embargo, la
                información se asociará con cualquier evaluación creada o modificada con este software; exportar y compartir
                la evaluación implica también compartir dicha información.</div>',
    ],

    'species' => [
        'timeline' => 'Especies',
        'info' => '<div>Este paso es necesario para integrar los datos de especies recuperados del <b>Catalogue of Life</b>
                en la aplicación. El conjunto de datos es requerido para identificar con precisión las especies durante
                las evaluaciones.</div><div>El conjunto de datos recuperado incluye todas las especies de animales y plantas.
                Por el momento se excluyen gusanos, ácaros, insectos y otros microorganismos. El conjunto de datos contiene
                la taxonomía completa y los nombres comunes (en varios idiomas).</div>',
        'citation' => 'Bánki, O., Roskov, Y., Döring, M., Ower, G., Hernández Robles, D. R., Plata Corredor, C. A.,
                Stjernegaard Jeppesen, T., Örn, A., Pape, T., Hobern, D., Garnett, S., Little, H., DeWalt, R. E., Miller,
                J., Orrell, T., Aalbu, R., Abbott, J., Aedo, C., Aescht, E., et al. (2025). <b>Catalogue of Life </b>
                (Version 2025-09-11). Catalogue of Life Foundation, Amsterdam, Netherlands.
                <a target="_blank" href="https://doi.org/10.48580/dgt98">https://doi.org/10.48580/dgt98</a>',
        'instructions' => 'Para integrar los datos de especies en la aplicación, haga clic en el siguiente botón. Este
                proceso puede tardar unos minutos, según el rendimiento de su dispositivo. Por favor, sea paciente y no
                cierre la aplicación.',
    ],

    'wdpas' => [
        'timeline' => 'Áreas protegidas y OECM',
        'info' => 'Este paso es necesario para integrar en la aplicación <b>la World Database on Protected Areas (WDPA)</b>
                y <b>la World Database on Other Effective Area-based Conservation Measures (WD-OECM)</b>. Los conjuntos
                de datos son necesarios para crear nuevas evaluaciones y asociarlas con el Área Protegida o OECM correspondiente.',
        'warning' => 'Tenga en cuenta que el proceso requiere conexión a Internet.',
        'citation' => 'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World
                Database on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge,
                UK: UNEP-WCMC and IUCN. Available at: <a target="_blank" href="https://protectedplanet.net/">www.protectedplanet.net.</a>',
        'instructions' => [
            'browse' => 'Abra el sitio web de <span class="highlight">Protected Planet</span> (<span class="highlight">www.protectedplanet.net</span>)',
            'navigate' => 'Haga clic en el botón <span class="highlight">Explore protected areas and OECMs</span>',
            'download' => 'Localice el botón <span class="highlight mr-0.5">Download</span> y proceda a descargar el
                archivo <span class="highlight mr-0.5">CSV</span>.<br />Se descargará un archivo <span class="highlight mr-0.5">ZIP</span>:
                <b>no es necesario</b> extraerlo.',
            'upload' => 'Haga clic en el siguiente botón <span class="highlight mr-0.5">Upload file</span> y seleccione el
                archivo <span class="highlight mr-0.5">ZIP</span> descargado',
            'apply' => 'Inicie la integración del conjunto de datos en la aplicación haciendo clic en el siguiente botón.',
            'completed' => 'El conjunto de datos está almacenado en la aplicación.',
            'update' => 'Si desea actualizar el conjunto de datos en el futuro, puede repetir el mismo procedimiento en
                cualquier momento desde la página de <span class="highlight">Configuración</span>.',
            'next' => 'Ahora puede proceder al siguiente paso.',
        ],
    ],

    'done' => [
        'timeline' => '¡Configuración completada!',
        'description' => 'La configuración está completa. Ahora puede comenzar a usar la aplicación.',
    ],
];
