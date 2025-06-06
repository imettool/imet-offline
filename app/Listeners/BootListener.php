<?php

namespace App\Listeners;

use App\Events\BootEvent;
use Log;

class BootListener
{
    public function handle(BootEvent $event): void
    {
        Log::info('BootEvent successfully listened!!.');

    }

}
