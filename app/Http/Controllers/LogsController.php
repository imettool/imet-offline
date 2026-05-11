<?php
/*
 * Copyright (C) 2026 European Union
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogsController extends Controller
{
    public function index(){

        $log_files = $this->getLogFiles();

        return view('offline.logs', [
            'log_files' => $log_files
        ]);
    }

    public function download(string $log)
    {
        $path = storage_path('logs/'.$log);
        $file = File::get($path);

        return response()->streamDownload(function () use ($file) {
            echo $file;
        }, $log);
    }


    private function getLogFiles(): array
    {
        $path = storage_path('logs');
        $files = File::allFiles($path);

        $log_files = [];
        foreach ($files as $file) {
            $log_files[] = $file->getFilename();
        }

        return $log_files;
    }

}


