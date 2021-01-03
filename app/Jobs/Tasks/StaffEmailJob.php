<?php

namespace App\Jobs\Tasks;

use App\Mail\TaskMail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StaffEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;
    public $currency;
    public function __construct(Task $task, $currency)
    {
        $this->task = $task;
        $this->currency = $currency;
    }

    public function handle()
    {   
        Mail::to($this->task->owner->email)
        ->queue(new TaskMail($this->task, $this->currency));
    }
}
