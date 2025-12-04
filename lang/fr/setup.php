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

    'setup' => 'Configuration',
    'please_follow_instructions' => 'Veuillez suivre les instructions ci-dessous',
    'next' => 'Suivant',
    'citation' => 'Citation',

    'timeline' => [

    ],

    'info' => [
        'timeline' => 'Commencer la configuration',
        'description' => 'Bienvenue dans l\'<b>Outil IMET hors ligne</b> !<br> C\'est la première fois que vous utilisez l\'application et une configuration rapide est requise pour commencer.',
        'offline_warning' => 'L\'outil IMET hors ligne est conçu pour être utilisé sur le terrain, où la connectivité Internet peut être limitée ou indisponible, mais pendant ce processus d\'installation <b>une connexion Internet est requise</b>. Veuillez vous assurer que vous êtes connecté à Internet avant de continuer.',
    ],

    'user' => [
        'timeline' => 'Informations personnelles',
        'info' => '<div>Les informations fournies resteront privées et stockées localement. Cependant, elles seront associées à toutes les évaluations créées ou modifiées avec ce logiciel ; l\'exportation et le partage de l\'évaluation impliquent donc également le partage des informations.</div>',
    ],

    'species' => [
        'timeline' => 'Espèces',
        'info' => '<div>Cette étape est nécessaire pour intégrer les données sur les espèces récupérées depuis le <b>Catalogue of Life</b> dans l\'application. Le jeu de données est requis afin d\'identifier précisément les espèces lors des évaluations.</div>
                    <div>Le jeu de données récupéré inclut toutes les espèces animales et végétales. Les vers, acariens, insectes et autres micro-organismes sont exclus pour le moment. Le jeu de données contient la taxonomie complète et les noms communs (en plusieurs langues).</div>',
        'citation' => 'Bánki, O., Roskov, Y., Döring, M., Ower, G., Hernández Robles, D. R., Plata Corredor, C. A.,
                    Stjernegaard Jeppesen, T., Örn, A., Pape, T., Hobern, D., Garnett, S., Little, H., DeWalt, R. E., Miller,
                    J., Orrell, T., Aalbu, R., Abbott, J., Aedo, C., Aescht, E., et al. (2025). <b>Catalogue of Life </b>
                    (Version 2025-09-11). Catalogue of Life Foundation, Amsterdam, Netherlands.
                    <a target="_blank" href="https://doi.org/10.48580/dgt98">https://doi.org/10.48580/dgt98</a>',
        'instructions' => "Pour intégrer les données d'espèces dans l'application, veuillez cliquer sur le bouton suivant. Ce processus peut prendre quelques minutes en fonction des performances de votre appareil. Veuillez patienter et ne pas fermer l'application.",
    ],

    'wdpas' => [
        'timeline' => 'Aires protégées et OECM',
        'info' => 'Cette étape est nécessaire pour intégrer <b>la Base de données mondiale sur les aires protégées (WDPA)</b> et <b>la Base de données mondiale sur d\'autres mesures efficaces basées sur des zones de conservation (WD-OECM)</b> dans l\'application. Les jeux de données sont nécessaires pour créer de nouvelles évaluations et les associer à l\'Aire protégée ou OECM correcte.',
        'warning' => 'Veuillez noter que le processus nécessite une connexion Internet.',
        'citation' => 'UNEP-WCMC and IUCN (2025), Protected Planet: The World Database on Protected Areas (WDPA) and World
                    Database on Other Effective Area-based Conservation Measures (WD-OECM) [Online], August 2025, Cambridge,
                    UK: UNEP-WCMC and IUCN. Available at:
                    <a target="_blank" href="https://protectedplanet.net/">www.protectedplanet.net.</a>',
        'instructions' => [
            'browse' => 'Accédez au site web <span class="highlight">Protected Planet</span>
                        (<span class="highlight">www.protectedplanet.net</span>)',
            'navigate' => 'Cliquez sur le bouton <span class="highlight">Explore protected areas and OECMs</span>',
            'download' => 'Localisez le bouton <span class="highlight mr-0.5">Download</span> et procédez au téléchargement du fichier <span class="highlight mr-0.5">CSV</span>.<br />Une archive <span class="highlight mr-0.5">ZIP</span> sera téléchargée : il n\'est <b>pas nécessaire</b> de l\'extraire.',
            'upload' => 'Cliquez sur le bouton <span class="highlight mr-0.5">Upload file</span> suivant et sélectionnez le fichier <span class="highlight mr-0.5">ZIP</span> téléchargé',
            'apply' => 'Démarrez l\'intégration du jeu de données dans l\'application en cliquant sur le bouton suivant.',
            'completed' => 'Le jeu de données est stocké dans l\'application.',
            'update' => 'Si vous souhaitez mettre à jour le jeu de données à l\'avenir, vous pouvez répéter la même procédure à tout moment depuis la page <span class="highlight">Paramètres</span>.',
            'next' => 'Vous pouvez maintenant passer à l\'étape suivante.',
        ],
    ],

    'done' => [
        'timeline' => 'Configuration terminée !',
        'description' => "La configuration est terminée. Vous pouvez maintenant commencer à utiliser l'application.",
    ],

];
