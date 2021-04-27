<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $company_details;
    public function __construct(Invoice $invoice, $company_details)
    {
        $this->invoice = $invoice;
        $this->company_details = $company_details;
    }

    public function build()
    {
        $subject = config('app.name')." | Invoice #".$this->invoice->id;
        return $this
        ->subject($subject)
        ->markdown('crm.invoice.email.client');
    }
}
