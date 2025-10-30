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

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Log;
use Native\Laravel\Facades\App;

class InitializeOfflineTool implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $relaunch_to_apply = false;

        // Force debug mode in the .env file
        $env_path = app_path() . '/../.env';
        if (file_exists($env_path)) {
            $env_content = file_get_contents($env_path);
            if(Str::contains($env_content, 'LOG_LEVEL=warning')) {
                $env_content = Str::replace('LOG_LEVEL=warning', 'LOG_LEVEL=debug', $env_content);
                file_put_contents($env_path, $env_content);
                Log::warning('LOG_LEVEL forced to debug in .env file.');
                $relaunch_to_apply = true;
            }
        } else {
            Log::error('Trying to force debug mode in .env file, but the file does not exist: ' . $env_path);
        }

        // Hard coded: set temporary Github token for auto-updater
        // TODO: remove as soon as the imet-offline repository is public
        $github_token = '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';
        $config_file_path = app_path() . '/../../../../app-update.yml';
        if (file_exists($config_file_path)) {
            $config_content = file_get_contents($config_file_path);
            if (!Str::contains($config_content, 'token:')) {
                file_put_contents($config_file_path, PHP_EOL . 'token: ' . $github_token, FILE_APPEND);
                Log::warning('GitHub token set in updater config yml file.');
                $relaunch_to_apply = true;
            }
        } else {
            Log::error('Trying to set GitHub token in updater config file, but the file does not exist: ' . $config_file_path);
        }

        // Relaunch the application to apply changes
        if($relaunch_to_apply) {
            Log::warning('Relaunching the application to apply changes.');
            App::relaunch();
        }
    }

}
