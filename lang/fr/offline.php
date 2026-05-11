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

    'title' => 'Outil IMET hors ligne',
    'version' => 'Version',
    'description' => '<b>IMET</b> est un outil d\'<i>évaluation de l\'efficacité de la gestion des aires protégées (PAME)</i> qui
        permet une évaluation approfondie des aires protégées marines et terrestres, quel que soit leur catégorie de gestion
        ou leur type de gouvernance. En tant qu\'outil d\'aide à la décision, il aide les gestionnaires d\'aires protégées
        à prendre des décisions de gestion basées sur l\'analyse afin d\'améliorer les résultats de conservation.',

    'update' => [

        'checking' => 'Recherche de mises à jour...',
        'available' => 'Nouvelle version disponible',
        'not_available' => 'Vous utilisez la dernière version.',
        'downloading' => 'Téléchargement de la nouvelle version...',
        'downloaded' => 'Nouvelle version téléchargée avec succès. Fermez l\'application pour appliquer la mise à jour.',
        'cancelled' => 'Mise à jour annulée.',
        'error' => 'Une erreur est survenue lors de la récupération de la mise à jour',

    ],

    'actions' => [
        'proceed' => 'Continuer',
        'quit_and_install' => 'Redémarrer pour appliquer',
        'applying_updated' => 'L\'application va redémarrer pour appliquer la mise à jour',
        'please_wait' => 'Veuillez patienter ...',
    ],

    'errors' => [
        'missing_api_token' => 'Jeton API manquant',
        'generic' => 'La requête a échoué',
    ],

    'logs' => [
        'logs-title' => 'Journaux',
        'logs-info' => 'Voici la liste des fichiers journaux générés par l\'application. Vous pouvez les télécharger et les envoyer à l\'équipe de support pour le dépannage.',
        'no_logs' => 'Aucun fichier journal généré pour le moment.',
    ],

];
