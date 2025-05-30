<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Native\Electron\Commands\ResetCommand;
use Symfony\Component\Filesystem\Filesystem;

use function Laravel\Prompts\intro;
use function Laravel\Prompts\info;
use function Laravel\Prompts\outro;

class ResetDevEnv extends Command
{
    protected $signature = 'imet:reset_dev_environment';

    protected $description = 'Resetting the development environment to a clean state';
    private Filesystem $filesystem;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

    public function handle(): int
    {
        // Reset the NativePHP development environment
        $this->call(ResetCommand::class, ['--with-app-data' => true]);

        // Delete logs
        intro('Clearing the logs');
        $this->removeFilesByExtension( base_path('storage/logs'), 'log');

        // Clear the assets and node_modules/ directories
        intro('Resetting node_modules/');
        $this->remove(base_path('node_modules/'));
        $this->remove(base_path('public/build'));
        $this->line('Running npm install');
        Process::run('npm install');
        $this->line('Running npm run build');
        Process::run('npm run build');

        // Clear the vendor directory
        intro('Resetting vendor/');
        $this->remove(base_path('vendor/'));
        $this->line('Running composer install');
        Process::run('composer install --no-interaction --optimize-autoloader');

        // Delete the database and create a new one
        intro('Resetting the database');
        $databasePath = config('database.connections.offline.database');
        static::remove($databasePath);
        $this->line('Creating new database file: ' . $databasePath);
        $this->filesystem->touch($databasePath);
        $this->line('Migrating the database');
        $this->call('migrate:refresh');

        // Run native:install
        intro('Running native:install');
        $this->call('native:install', ['--force' => true, '--installer' => 'npm']);

        info('Development environment reset successfully!');

        return 0;
    }

    private function remove(string $path): void
    {
        if ($this->filesystem->exists($path)) {
            $this->line('Deleting: ' . $path);
            $this->filesystem->remove($path);
        }
    }

    private function removeFilesByExtension(string $path, string $extension): void
    {
        foreach (array_diff(scandir($path), array('.', '..')) as $file) {
            if(\Str::endsWith($file, '.' . $extension)) {
                $filePath = $path . '/' . $file;
                if ($this->filesystem ->exists($filePath)) {
                    $this->line('Deleting: ' . $filePath);
                    $this->filesystem ->remove($filePath);
                }
            }
        }
    }

}

