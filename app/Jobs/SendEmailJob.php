<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\RegisterStaffMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $password;
    public $company_details;
    public function __construct(User $user, $password, $company_details)
    {
        $this->user = $user;
        $this->password = $password;
        $this->company_details = $company_details;
        
    }

    public function handle()
    {
        Mail::to($this->user->email)
        ->queue(new RegisterStaffMail($this->user, $this->password, $this->company_details));
    }
}
