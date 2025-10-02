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

use App\Events\TaskProgressing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DummyJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $jobId;
    public array $zipFiles;


    public function __construct(string $jobId, array $zipFiles = [])
    {
        $this->jobId = $jobId;
        $this->zipFiles = $zipFiles;
    }

    public function handle(): int
    {
        $numSeconds = 4;

        try{
            for ($i = 1; $i <= $numSeconds; $i++) {
                sleep(1);
                $progress = round(($i / $numSeconds) * 100);
                TaskProgressing::dispatch($this->jobId, $progress);
            }
            return 0;

        } catch (\Exception $e) {
            \Log::error('Error in DummyJob: ' . $e->getMessage());
            return 1;
        }


    }
}
