<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterStaffMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $company_details;


    public function __construct(User $user, $password, $company_details)
    {
        $this->user = $user;
        $this->password = $password;
        $this->company_details = $company_details;
    }

    public function build()
    {
        $subject = config('app.name')." | Account Registered -".$this->user->email;
        return $this
        ->subject($subject)
        ->markdown('crm.user.email.register');
    }
}
