<?php
/*
 * Copyright (C) 2025 European Union
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * EUROPEAN UNION PUBLIC LICENCE v. 1.2 as published by the European Union.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the EUROPEAN UNION PUBLIC LICENCE v. 1.2 for
 * further details. You should have received a copy of the EUROPEAN UNION PUBLIC LICENCE v. 1.2. along with this program.
 * If not, see <https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12 >.
 */

namespace App\Jobs;

use App\Models\JobProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
            JobProgress::updateJobProgress($this->jobId);
            for ($i = 1; $i <= $numSeconds; $i++) {
                sleep(1);
                JobProgress::updateJobProgress($this->jobId, round(($i / $numSeconds) * 100));
            }
            return 0;

        } catch (\Exception $e) {
            \Log::error('Error in DummyJob: ' . $e->getMessage());
            return 1;
        }


    }
}
