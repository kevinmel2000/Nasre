<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskMail extends Mailable
{
    use Queueable, SerializesModels;
    public $task;
    public $currency;

    public function __construct(Task $task, $currency)
    {
        $this->task = $task;
        $this->currency = $currency;
    }

    public function build()
    {
        $subject = config('app.name')." | Task #".$this->task->id;
        return $this
        ->subject($subject)
        ->markdown('crm.task.email.staff');
    }
}
