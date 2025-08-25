<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class JobProgress extends Model
{
    use HasUuids;

    protected $table = 'jobs_progress';
    protected $primaryKey = 'job_id';

    protected $fillable = ['job_id', 'progress'];

    /**
     * Update the progress of a job.
     */
    public static function updateJobProgress($job_id, $progress = 0): JobProgress
    {
        return self::updateOrCreate(
            ['job_id' => $job_id],
            ['progress' => $progress]
        );
    }

}
