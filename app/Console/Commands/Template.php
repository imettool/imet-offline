<?php

namespace App\Console\Commands;

use AndreaMarelli\ImetCore\Models\ProtectedArea;
use App\Models\ProtectedAreaUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Template extends Command
{

    protected $signature = 'imet:template_command';

    protected $description = 'Empty template to be used for executing temporary commands';

    public function handle(): int
    {

        return 0;
    }

}
