<?php

namespace App\Console;

use App\Console\Commands\changeStage;
use App\Console\Commands\disease;
use App\Console\Commands\fieldClean;
use App\Console\Commands\temperature;
use App\Console\Commands\watering;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{


    protected $commands = [
        temperature::class,
        changeStage::class,
        disease::class,
        fieldClean::class,
        watering::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('humidity:change')->runInBackground()->everyMinute();
        $schedule->command('change:stage')->everyMinute();
        $schedule->command('alert:disease')->everyMinute();
        $schedule->command('field:clean')->everyMinute();
        $schedule->command('watering:alert')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleTimezone()
    {
        return 'Asia/Damascus';
    }
}
