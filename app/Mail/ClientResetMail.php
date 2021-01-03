<?php

namespace App\Mail;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientResetMail extends Mailable
{
    use Queueable, SerializesModels;
    public $customer;
    public $token;
  
    public function __construct(Customer $customer, $token)
    {
        $this->customer = $customer;
        $this->token = $token;
    }

    public function build()
    {
        $subject = 'Reset Password Notification';
        return $this
        ->subject($subject)
        ->markdown('client.auth.passwords.email.reset');
    }
}
