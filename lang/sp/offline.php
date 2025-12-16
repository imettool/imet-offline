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

    'title' => 'Herramienta IMET sin conexión',
    'version' => 'Versión',
    'description' => '<b>IMET</b> es una herramienta de <i>Evaluación de la Eficacia de la Gestión de Áreas Protegidas (PAME)</i> que
        permite una evaluación en profundidad de áreas protegidas marinas y terrestres, independientemente de sus categorías
        de gestión y tipo de gobernanza. Como herramienta de apoyo a la toma de decisiones, ayuda a los gestores de áreas
        protegidas a tomar decisiones de gestión basadas en el análisis para mejorar los resultados de conservación.',

    'update' => [

        'checking' => 'Buscando actualizaciones...',
        'available' => 'Nueva versión disponible',
        'not_available' => 'Estás usando la última versión.',
        'downloading' => 'Descargando nueva versión...',
        'downloaded' => 'Nueva versión descargada con éxito. Cierra la aplicación para aplicar la actualización.',
        'cancelled' => 'Actualización cancelada.',
        'error' => 'Ocurrió un error al recuperar la actualización',

    ],

    'actions' => [
        'proceed' => 'Continuar',
        'quit_and_install' => 'Reiniciar para aplicar',
        'applying_updated' => 'La aplicación se reiniciará para aplicar la actualización',
        'please_wait' => 'Por favor espera ...',
    ],

    'errors' => [
        'missing_api_token' => 'Falta el token API',
        'generic' => 'La solicitud falló',
    ],

];
