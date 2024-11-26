<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('app:retrieve-rates')->everyFifteenMinutes();
         $schedule->command('app:register-discounts')
            ->everyMinute()
            ->when(function () {
                $now = now();
                return $now->month === 9 && $now->day === 1 && $now->hour === 0;
            });

        $schedule->command('app:new-member-discount')
            ->everyMinute()
            ->when(function () {
                $now = now();
                return $now->month === 6 && $now->day === 1 && $now->hour === 0;
            });

        $schedule->command('app:calculate-balance')
            ->everyMinute()
            ->when(function () {
                $now = now();
                return $now->month === 7 && $now->day === 1 && $now->hour === 0;
            });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
