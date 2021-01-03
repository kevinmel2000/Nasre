<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\Currency;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Models\InvoiceProduct;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use App\Jobs\Invoices\ClientEmailJob;
use PDF;

class InvoiceController extends Controller
{
    function company_details(){
        $company_details = [];
        $company_name = SingleRowData::where('field_name','company_name')->first();
        array_push($company_details, $company_name);
        $company_address = SingleRowData::where('field_name','company_address')->first();
        array_push($company_details, $company_address);
        $company_city = SingleRowData::where('field_name','company_city')->first();
        array_push($company_details, $company_city);
        $company_state = SingleRowData::where('field_name','company_state')->first();
        array_push($company_details, $company_state);
        $company_country = SingleRowData::where('field_name','company_country')->first();
        array_push($company_details, $company_country);
        $company_zip = SingleRowData::where('field_name','company_zip')->first();
        array_push($company_details, $company_zip);
        $company_phone = SingleRowData::where('field_name','company_phone')->first();
        array_push($company_details, $company_phone);
        $company_email = SingleRowData::where('field_name','company_email')->first();
        array_push($company_details, $company_email);
        return $company_details;
    }

    public function index()
    {
        $route_active = 'invoice';
        $user = Auth::user();
        if ($user->role_id != '1') {
            $invoices = Invoice::where('invoice_owner_id',$user->id)->orwhere('created_by_id',$user->id)->orderby('id','desc')->get();
        }else{
            $invoices = Invoice::orderby('id','desc')->get();
        }
        $invoice_ids = response()->json($invoices->modelKeys());

        $company_details = $this->company_details();

        $extraButtons = [];
        foreach ($invoices as $invoice) {
            $extraButtons[$invoice->id] = 'onmouseover="showExtraButtons('.$invoice->id.')" onmouseout="hideExtraButtons('.$invoice->id.')"';
        }

        $payment_modes = PaymentMode::where('is_active','yes')->get();
        $currencies = Currency::get();
        $invoiceProducts = InvoiceProduct::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.invoice.index', compact(['route_active', 'invoices','invoiceProducts','base_currency','salesperson','currencies','company_details','payment_modes','invoice_ids', 'extraButtons']));  
    }

    public function invoice_pdf(Invoice $invoice){
        $company_details = $this->company_details();
        $products = $invoice->invoiceProducts;
     
       $pdf = PDF::loadView('crm.invoice.invoice_pdf', compact('invoice','company_details','products'));
 
       // download PDF file with download method
       return $pdf->stream('pdf_file.pdf');
    }

    public function mailToClient(Invoice $invoice){
        $company_details = $this->company_details();

        if($invoice->status == 'draft'){
            $invoice->status = 'sent';
            $invoice->save();
        }

        ClientEmailJob::dispatch($invoice, $company_details);
        $notification = array(
            'message' => 'Email sent successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function getProduct(Request $request){
        $product= Product::find($request->product_id);
        return response()->json([
            'product_id'=>$request->product_id,
            'product'=>$product
        ]);
    }

    public function getCustomers(){
        $customers= Customer::get();
        return response()->json([
            'message'=>'success',
            'customers'=>$customers,
        ]);
    }

    public function getInvoiceProducts(Request $request){
        $invoice_products= InvoiceProduct::where(['invoice_id'=>$request->invoice_id])->get();
        return response()->json([
            'message'=>'success',
            'invoice_products'=>$invoice_products
        ]);        
    }

    public function get_pay_details($id){
        $payment_mode = PaymentMode::where(['id'=>$id])->first();
        return response()->json([
            'id'=>$id,
            'payment_mode'=>$payment_mode,
            'status'=>'success'
        ]);
    }

    public function pay_invoice(Request $request)
    {
        $invoice = Invoice::where(['id'=>$request->invoice_number])->first();
        if($request->has('txn_receipt')){
            // if you want to delete the image from the directory
           $extension = ".".$request->txn_receipt->getClientOriginalExtension();
           $name = basename($request->txn_receipt->getClientOriginalName(), $extension).time();
           $name = $name.$extension;
           $path = $request->txn_receipt->storeAs('invoice_receipts',$name,'public');
           if($extension == '.png' || $extension == '.jpg' || $extension == '.jpeg' || $extension == '.gif' || $extension == '.PNG' || $extension == '.JPG' || $extension == '.JPEG' || $extension == '.GIF') {
               $extension = 'image';
           }
           $invoice->txn_receipt = $name;
         }
            $today = Carbon::today()->toDateString();
            $today = Carbon::create($today);
            $due_date = Carbon::create($invoice->due_date);
            // dd($today->diff($due_date)->invert);
            // Invert == 1, means due date is in the past of the today date.
            if($today->diff($due_date)->invert == 1){
                $notification = array(
                    'message' => 'Due date has been passed for this invoice, Adjust the due date or create new invoice!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);   
            }

            // Because if invoice is paid, it must be visible to the customer. and Draft invoices are not visible to the customer.
            if($invoice->status == 'draft'){
                    $invoice->status = 'open';
            }

            $invoice->invoice_paid = 'yes';
            $invoice->payment_mode_id = $request->payment_mode_id;
            $invoice->payment_time = now();
            $invoice->txn_number = $request->txn_number;
           

        if($invoice->save()){
            $notification = array(
                'message' => 'Your invoice paid successfully, please wait for the confirmation!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function confirm_payment(Request $request){
        $invoice = Invoice::where(['id'=> $request->invoice_id])->first();
        $invoice->payment_confirmed = 'yes';
        if ($invoice->save()) {
            $notification = array(
                'message' => 'Invoice confirmed successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);  
        }else{
            $notification = array(
                'message' => 'Please refresh the page and try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);  
        }
    }

    public function create($relation = false, $id=false)
    {
        $route_active = 'invoiceCreate';
        $taxrates = TaxRate::get();
        $currencies = Currency::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $products = Product::where('status','active')->get();
        $terms  = SingleRowData::where(['field_name'=>'terms'])->first();
        return view('crm.invoice.create', compact(['route_active', 'taxrates','currencies','salesperson','products','relation','id','terms']));  
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'invoice_number'=>'required',
            'invoice_title'=>'required',
        ]);
        if($validator){
            $user = Auth::user();
            $invoice = Invoice::create([
                'invoice_number'=>$request->invoice_number,
                'invoice_title'=>$request->invoice_title,
                'customer_id'=>$request->customer_id,
                'invoice_owner_id'=>$request->invoice_owner_id,
                'invoice_date'=>$request->invoice_date,
                'due_date'=>$request->due_date,
                'status'=>$request->status,
                'currency_id'=>$request->currency_id,
                'amount_due'=>$request->amount_due,
                'amount_paid'=>$request->amount_paid,
                'shipping_charges'=>$request->shipping_charges,
                'termsandconditions'=>$request->termsandconditions,
                'customer_notes'=>$request->customer_notes,
                'sub_total'=>$request->sub_total,
                'discount_type'=>$request->discount_type,
                'discount_percentage'=>$request->discount_percentage,
                'discount_total'=>$request->discount_total,
                'adjustments'=>$request->adjustments,
                'total_amount'=>$request->total_amount,
                'created_by_id'=>$user->id
            ]);

            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    InvoiceProduct::create([
                        'invoice_id'=>$invoice->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }    
            if ($request->send_email != null) {
                return $this->mailToClient($invoice);
            }
            $notification = array(
                'message' => 'Invoice submitted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function edit(Invoice $invoice)
    {
        $route_active = 'invoice';
        $taxrates = TaxRate::get();
        $currencies = Currency::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $products = Product::where('status','active')->get();
        return view('crm.invoice.edit', compact(['route_active', 'taxrates','currencies','salesperson','products','invoice']));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validator = $request->validate([
            'invoice_number'=>'required',
            'invoice_title'=>'required',
        ]);
        if($validator){
            $invoice->invoice_number = $request->invoice_number;
            $invoice->invoice_title = $request->invoice_title;
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_owner_id = $request->invoice_owner_id;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->status = $request->status;
            $invoice->currency_id = $request->currency_id;
            $invoice->amount_due = $request->amount_due;
            $invoice->amount_paid = $request->amount_paid;
            $invoice->shipping_charges = $request->shipping_charges;
            $invoice->termsandconditions = $request->termsandconditions;
            $invoice->customer_notes = $request->customer_notes;

            $invoice->sub_total = $request->sub_total;
            $invoice->discount_type = $request->discount_type;
            $invoice->discount_percentage = $request->discount_percentage;
            $invoice->discount_total = $request->discount_total;
            $invoice->adjustments = $request->adjustments;
            $invoice->total_amount = $request->total_amount;

            $invoice->save();

            $invoice_products = InvoiceProduct::where(['invoice_id'=>$invoice->id])->delete();


            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    InvoiceProduct::create([
                        'invoice_id'=>$invoice->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }    
            $notification = array(
                'message' => 'Invoice updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(Invoice $invoice)
    {
        InvoiceProduct::where('invoice_id', $invoice->id)->delete();
        if ($invoice->delete()) {
            $notification = array(
                'message' => 'Invoice deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);  
        }else{
            $notification = array(
                'message' => 'Please try again or Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);  
        }
    }
}
