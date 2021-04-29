<?php

namespace App\Jobs\Invoices;

use App\Models\Invoice;
use App\Mail\InvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClientEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $invoice;
    public $company_details;
    public function __construct(Invoice $invoice, $company_details)
    {
        $this->invoice = $invoice;
        $this->company_details = $company_details;
    }

    public function handle()
    {
        Mail::to($this->invoice->customer->first_contact->email)
        ->queue(new InvoiceMail($this->invoice, $this->company_details));
    }
}
