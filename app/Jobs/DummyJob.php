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

    public $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }

    public function handle(array $zip_files = [])
    {
        $numSeconds = 5;

        try{
            foreach ($zip_files as $file) {
                \Log::info("Processing file: " . $file);
            }
            for ($i = 1; $i <= $numSeconds; $i++) {
                sleep(1);
            }
            return 0;
        } catch (\Exception $e) {
            \Log::error('Error in DummyJob: ' . $e->getMessage());
            return 1;
        }


    }
}
