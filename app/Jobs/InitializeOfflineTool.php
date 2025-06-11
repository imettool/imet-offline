<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Log;

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

        // Force debug mode in the .env file
        $env_path = app_path() . '/../.env';
        $env_content = file_get_contents($env_path);
        if(Str::contains($env_content, 'LOG_LEVEL=warning')) {
            $env_content = Str::replace('LOG_LEVEL=warning', 'LOG_LEVEL=debug', $env_content);
            file_put_contents($env_path, $env_content);
            Log::info('LOG_LEVEL forced to debug in .env file.');
        }

        // Hard coded: set temporary Github token for auto-updater
        // TODO: remove as soon as the imet-offline repository is public
        $github_token = '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';
        $config_file_path = app_path() . '/../../../../app-update.yml';
        if (file_exists($config_file_path)) {
            Log::info('Config file found: ' . $config_file_path);
            $config_content = file_get_contents($config_file_path);
            if (!Str::contains($config_content, 'token:')) {
                file_put_contents($config_file_path, PHP_EOL . 'token: ' . $github_token, FILE_APPEND);
                Log::info('GitHub token set in updater config yml file.');
            }
        } else {
            Log::warning('Config file not found: ' . $config_file_path);
        }

        // Hard coded fix to issue https://github.com/NativePHP/laravel/issues/614  (already fixed with https://github.com/NativePHP/laravel/pull/597)
        // TODO: to be removed when the PR is merged and released
        $native_events_path = app_path() . '/../vendor/nativephp/laravel/src/Events/AutoUpdater/';
        $event_files = [
            'Error.php',
            'UpdateAvailable.php',
            'UpdateCancelled.php',
            'UpdateDownloaded.php',
            'UpdateNotAvailable.php',
        ];
        foreach ($event_files as $file) {
            $file_path = $native_events_path . $file;
            if (file_exists($file_path)) {
                $content = file_get_contents($file_path);
                if(!Str::contains($content, ' = null,')){
                    $content = str_replace('public ?string $stack,', 'public ?string $stack = null,', $content);
                    $content = str_replace('public ?string $releaseName,', 'public ?string $releaseName = null,', $content);
                    $content = str_replace('public string|array|null $releaseNotes,', 'public string|array|null $releaseNotes = null,', $content);
                    $content = str_replace('public ?int $stagingPercentage,', 'public ?int $stagingPercentage = null,', $content);
                    $content = str_replace('public ?string $minimumSystemVersion,', 'public ?string $minimumSystemVersion = null,', $content);
                    file_put_contents($file_path, $content);
                    Log::info('Fixed ' . $file . ' event file. (https://github.com/NativePHP/laravel/issues/614)');
                }
            }
        }

    }

}
