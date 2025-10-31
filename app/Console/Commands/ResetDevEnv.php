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

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Support\Facades\Process;
use Native\Electron\Commands\InstallCommand;
use Native\Electron\Commands\ResetCommand;
use Symfony\Component\Filesystem\Filesystem;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;

class ResetDevEnv extends Command
{
    protected $signature = 'imet:reset_dev_environment';

    protected $description = 'Resetting the development environment to a clean state';

    private readonly Filesystem $filesystem;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

    public function handle(): int
    {
        // Reset the NativePHP development environment
        $this->call(ResetCommand::class, ['--with-app-data' => true]);

        // Clear storage
        intro('Clearing the storage');
        $this->clearFolder(storage_path('app'), ['public', 'private', '.gitignore']);
        $this->clearFolder(storage_path('framework/cache/data'), ['.gitignore']);
        $this->clearFolder(storage_path('framework/cache'), ['data', '.gitignore']);
        $this->clearFolder(storage_path('framework/sessions'), ['.gitignore']);
        $this->clearFolder(storage_path('framework/testing'), ['.gitignore']);
        $this->clearFolder(storage_path('framework/views'), ['.gitignore']);
        $this->clearFolder(storage_path('framework'), ['cache', 'sessions', 'testing', 'views', '.gitignore']);
        $this->clearFolder(storage_path('logs'), ['.gitignore']);
        $this->clearFolder(storage_path('releases'), ['.gitkeep']);

        // Clear the assets and node_modules/ directories
        intro('Resetting node_modules/');
        $this->remove(base_path('node_modules/'));
        $this->remove(base_path('public/build'));
        $this->remove(base_path('public/basket'));
        $this->components->line('info', 'Running npm install');
        Process::run('npm install');
        $this->components->line('info', 'Running npm run build');
        Process::run('npm run build');

        // Clear the vendor directory
        intro('Resetting vendor/');
        $this->remove(base_path('vendor/'));
        $this->components->line('info', 'Running composer install');
        Process::run('composer install --no-interaction --optimize-autoloader');

        // Delete the database and create a new one
        intro('Resetting the database');
        self::remove(database_path('nativephp.sqlite'));
        self::remove(database_path('nativephp.sqlite-shm'));
        self::remove(database_path('nativephp.sqlite-wal'));
        $databasePath = config('database.connections.offline.database');
        self::remove($databasePath);
        $this->components->line('info', 'Creating new database file: '.$databasePath);
        $this->filesystem->touch($databasePath);
        $this->components->line('info', 'Migrating the database');
        $this->call(RefreshCommand::class);

        // Run native:install
        intro('Running native:install');
        $this->call(InstallCommand::class, ['--force' => true, '--installer' => 'npm']);

        info('Development environment reset successfully!');

        return 0;
    }

    /**
     * Remove a file or directory if it exists
     */
    private function remove(string $path): void
    {
        if ($this->filesystem->exists($path)) {
            $this->line('Deleting: '.$path);
            $this->filesystem->remove($path);
        }
    }

    /**
     * Clear all files and folders in a directory except those specified in the $except array
     *
     * @param  array<int, string>  $except
     */
    private function clearFolder(string $path, array $except = []): void
    {
        foreach (array_diff(scandir($path), ['.', '..']) as $item) {
            if (! in_array($item, $except)) {
                self::remove($path.'/'.$item);
            }
        }
    }
}
