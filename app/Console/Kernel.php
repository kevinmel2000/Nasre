<?php
namespace App\Console;

use App\Jobs\SendEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();  
        // Queued import/export/campaign
        $schedule->command('queue:work --once --tries=3')->everyMinute();    
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
