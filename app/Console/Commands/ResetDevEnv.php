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
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Foundation\Console\ClearCompiledCommand;
use Illuminate\Foundation\Console\ConfigClearCommand;
use Illuminate\Foundation\Console\EventClearCommand;
use Illuminate\Foundation\Console\RouteClearCommand;
use Illuminate\Foundation\Console\ViewClearCommand;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Native\Desktop\Drivers\Electron\Commands\InstallCommand;
use Native\Desktop\Drivers\Electron\Commands\ResetCommand;
use Symfony\Component\Filesystem\Filesystem;

use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;

class ResetDevEnv extends Command
{
    protected $signature = 'imet:reset_dev_environment {--clean-only}';

    protected $description = 'Resetting the development environment to a clean state';

    private readonly Filesystem $filesystem;

    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

    public function handle(): int
    {
        $clean_only = $this->option('clean-only', false);
        $do_refresh = !$clean_only;

        $databasePath = config('database.connections.offline.database');

        // Laravel application cache clear
        intro('Clearing Laravel caches');
        $this->call(ConfigClearCommand::class);
        $this->call(ClearCompiledCommand::class);
        $this->call(EventClearCommand::class);
        $this->call(RouteClearCommand::class);
        $this->call(ViewClearCommand::class);

        // Reset the NativePHP development environment
        $this->call(ResetCommand::class, ['--with-app-data' => true]);
        $this->clearFolder(base_path('nativephp'));

        // Clear storage
        intro('Clearing the storage');
        $this->clearFolder(storage_path(), [
            'storage/app/.gitignore',
            'storage/app/private/.gitignore',
            'storage/app/public/.gitignore',
            'storage/framework/.gitignore',
            'storage/framework/cache/.gitignore',
            'storage/framework/cache/data/.gitignore',
            'storage/framework/sessions/.gitignore',
            'storage/framework/testing/.gitignore',
            'storage/framework/views/.gitignore',
            'storage/logs/.gitignore',
            'storage/releases/.gitkeep'
        ]);

        // Clear the assets and node_modules/ directories
        intro('Resetting node_modules/');
        $this->clearFolder(base_path('node_modules'));
        $this->clearFolder(base_path('public/build'));
        $this->clearFolder(base_path('public/basket'));
        if($do_refresh){
            $this->line( 'Running npm install');
            Process::run('npm install');
            $this->line( 'Running npm run build');
            Process::run('npm run build');
        }

        // Clear the vendor directory
        intro('Resetting vendor/');
        $this->clearFolder(base_path('vendor/'));
        if($do_refresh) {
            $this->line('Running composer install');
            Process::run('composer install --no-interaction --optimize-autoloader');
        }

        // Delete the database and create a new one
        intro('Resetting the database');
        self::remove(database_path('nativephp.sqlite'));
        self::remove(database_path('nativephp.sqlite-shm'));
        self::remove(database_path('nativephp.sqlite-wal'));
        self::remove($databasePath);
        if($do_refresh) {
            $this->line('Creating new database file: ' . $databasePath);
            $this->filesystem->touch($databasePath);
            $this->line('Migrating the database');
            $this->call(MigrateCommand::class);
        }

        // Run native:install
        if($do_refresh) {
            intro('Running native:install');
            $this->call(InstallCommand::class, ['--force' => true, '--installer' => 'npm']);
        }

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
    private function clearFolder(string $path, array $except = [], bool $verbose = true): void
    {
        $path = rtrim($path, '/');

        if ($this->filesystem->exists($path)) {

            if($verbose) {
                $this->line('Deleting: '.$path);
            }

            $files = array_diff(scandir($path), ['.', '..']);

            foreach ($files as $item) {

                $fullPath = $path . '/' . $item;
                $relativePath = Str::replace(base_path() . '/', '', $fullPath);

                if(is_dir($fullPath)){
                    $this->clearFolder($fullPath, $except, false);
                } else {
                    if(!in_array($relativePath, $except, true)) {
                        $this->filesystem->remove($fullPath);
                    }
                }

                // Remove folder emptied after file removal
                if(count(array_diff(scandir($path), ['.', '..']))===0){
                    $this->filesystem->remove($path);
                }
            }

        }
    }
}
