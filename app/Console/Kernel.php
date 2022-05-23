<?php

namespace App\Console;

use App\Console\Commands\Core\MakeController;
use App\Console\Commands\Core\MakeInterface;
use App\Console\Commands\Core\MakeModel;
use App\Console\Commands\Core\MakeRepository;
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
        MakeInterface::class,
        MakeRepository::class,
        MakeModel::class,
        MakeController::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
