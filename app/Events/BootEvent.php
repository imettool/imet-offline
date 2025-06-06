<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;

class BootEvent implements ShouldBroadcastNow
{
    public function broadcastOn(): array
    {
        Log::info('BootEvent event dispatched.');
        return [
            new Channel('nativephp'),
        ];
    }
}
