<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Mlntn\Console\Commands\Serve::class,
        \Nord\Lumen\DynamoDb\Console\CreateTablesCommand::class,
        \Nord\Lumen\DynamoDb\Console\DeleteTablesCommand::class,
    ];
}
