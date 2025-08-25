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

use App\Helpers\ProtectedAreaUpdaterCSV;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateProtectedAreas implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $zipFilePath;
    private string $originalFilename;
    private string $jobId;

    public function __construct(string $zipFilePath, string $originalFilename, string $jobId)
    {
        $this->zipFilePath = $zipFilePath;
        $this->originalFilename = $originalFilename;
        $this->jobId = $jobId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Job UpdateProtectedAreas launched.');

        try{
            ProtectedAreaUpdaterCSV::updateProtectedAreasAndOECMs($this->zipFilePath, $this->originalFilename, $this->jobId);
            Log::info('Job UpdateProtectedAreas completed successfully.');

        } catch (Exception $e) {
            Log::error('Error executing job UpdateProtectedAreas: ' . $e->getMessage());
        }
    }
}
