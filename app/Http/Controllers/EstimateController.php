<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\Currency;
use App\Models\Estimate;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Models\EstimateProduct;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use App\Jobs\Invoices\ClientEmailJob;
use App\Jobs\Estimates\ClientEmailJob as EstimatesClientEmailJob;
use PDF;
class EstimateController extends Controller
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
        $route_active = 'estimate';
        $user = Auth::user();
        if ($user->role_id != '1') {
            $estimates = Estimate::where('estimate_owner_id',$user->id)->orwhere('created_by_id',$user->id)->orderby('id','desc')->get();
        }else{
            $estimates = Estimate::orderby('id','desc')->get();
        }
        $estimate_ids = response()->json($estimates->modelKeys());
 
        $company_details = $this->company_details();
        $extraButtons = [];
        foreach ($estimates as $estimate) {
            $extraButtons[$estimate->id] = 'onmouseover="showExtraButtons('.$estimate->id.')" onmouseout="hideExtraButtons('.$estimate->id.')"';
        }

        $currencies = Currency::get();
        $estimateProducts = EstimateProduct::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.estimate.index', compact(['route_active', 'estimates','estimateProducts','base_currency','salesperson','currencies','company_details','estimate_ids' ,'extraButtons']));  
    }

    public function estimate_pdf(Estimate $estimate){
        $company_details = $this->company_details();
        $products = $estimate->estimateProducts;
     
       $pdf = PDF::loadView('crm.estimate.estimate_pdf', compact('estimate','company_details','products'));
 
       // download PDF file with download method
       return $pdf->stream('pdf_file.pdf');
    }

    public function mailToClient(Estimate $estimate){
        $company_details = $this->company_details();
 
        EstimatesClientEmailJob::dispatch($estimate, $company_details);

        $notification = array(
            'message' => 'Mail added in the queue successfully!',
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

    public function getestimateProducts(Request $request){
        $estimate_products= EstimateProduct::where(['estimate_id'=>$request->estimate_id])->get();
        return response()->json([
            'message'=>'success',
            'estimate_products'=>$estimate_products
        ]);        
    }

    public function create($relation = false, $id=false)
    {
        $route_active = 'estimateCreate';
        $taxrates = TaxRate::get();
        $currencies = Currency::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $products = Product::where('status','active')->get();
        return view('crm.estimate.create', compact(['route_active', 'taxrates','currencies','salesperson','products','relation','id']));  
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'estimate_number'=>'required',
            'estimate_title'=>'required',
        ]);
        if($validator){
            $user = Auth::user();
            $estimate = Estimate::create([
                'estimate_number'=>$request->estimate_number,
                'estimate_title'=>$request->estimate_title,
                'customer_id'=>$request->customer_id,
                'estimate_owner_id'=>$request->estimate_owner_id,
                'estimate_date'=>$request->estimate_date,
                'due_date'=>$request->due_date,
                'status'=>$request->status,
                'currency_id'=>$request->currency_id,
                'shipping_charges'=>$request->shipping_charges,
                'termsandconditions'=>$request->termsandconditions,
                'customer_notes'=>$request->customer_notes,

                'sub_total'=>$request->sub_total,
                'discount_type'=>$request->discount_type,
                'discount_percentage'=>$request->discount_percentage,
                'discount_total'=>$request->discount_total,
                'adjustments'=>$request->adjustments,
                'total_amount'=>$request->total_amount,
                'invoiced_token'=>md5($request->estimate_number.now()),
                'created_by_id'=>$user->id
            ]);

            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    EstimateProduct::create([
                        'estimate_id'=>$estimate->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }   
            if ($request->send_email != null) {
                return $this->mailToClient($estimate);
            } 
            $notification = array(
                'message' => 'Estimate submitted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function edit(estimate $estimate)
    {
        $route_active = 'estimate';
        $taxrates = TaxRate::get();
        $currencies = Currency::get();
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $products = Product::where('status','active')->get();
        return view('crm.estimate.edit', compact(['route_active', 'taxrates','currencies','salesperson','products','estimate']));
    }

    public function update(Request $request, estimate $estimate)
    {
        $validator = $request->validate([
            'estimate_number'=>'required',
            'estimate_title'=>'required',
        ]);
        if($validator){
            $estimate->estimate_number = $request->estimate_number;
            $estimate->estimate_title = $request->estimate_title;
            $estimate->customer_id = $request->customer_id;
            $estimate->estimate_owner_id = $request->estimate_owner_id;
            $estimate->estimate_date = $request->estimate_date;
            $estimate->due_date = $request->due_date;
            $estimate->status = $request->status;
            $estimate->currency_id = $request->currency_id;
            $estimate->shipping_charges = $request->shipping_charges;
            $estimate->termsandconditions = $request->termsandconditions;
            $estimate->customer_notes = $request->customer_notes;

            $estimate->sub_total = $request->sub_total;
            $estimate->discount_type = $request->discount_type;
            $estimate->discount_percentage = $request->discount_percentage;
            $estimate->discount_total = $request->discount_total;
            $estimate->adjustments = $request->adjustments;
            $estimate->total_amount = $request->total_amount;
            $estimate->invoiced_token = md5($request->estimate_number.now());
            $estimate->save();

            $estimate_products = EstimateProduct::where(['estimate_id'=>$estimate->id])->delete();


            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    EstimateProduct::create([
                        'estimate_id'=>$estimate->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }    
            $notification = array(
                'message' => 'estimate updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function convertToInvoice(Estimate $estimate, $token){
        if ($estimate->invoiced_token != $token) {
            return abort(404);
        }else{

            // If Invoiced token matched
            $invoice = Invoice::create([
                'invoice_number'=>$estimate->estimate_number,
                'invoice_title'=>$estimate->estimate_title,
                'invoice_owner_id'=>$estimate->estimate_owner_id,
                'customer_id'=>$estimate->customer_id,
                'contact_id'=>$estimate->contact_id,
                'billing_address_id'=>$estimate->billing_address_id,
                'shipping_address_id'=>$estimate->shipping_address_id,
                'invoice_date'=>$estimate->estimate_date,
                'due_date'=>$estimate->due_date,
                'currency_id'=>$estimate->currency_id,
                'discount_type'=>$estimate->discount_type,
                'discount_percentage'=>$estimate->discount_percentage,
                'discount_total'=>$estimate->discount_total,
                'total_amount'=>$estimate->total_amount,
                'sub_total'=>$estimate->sub_total,
                'adjustments'=>$estimate->adjustments,
                'amount_due'=>$estimate->total_amount,  // total amount due
                'amount_paid'=>0,
                'status'=>$estimate->status,
                'payment_options'=>$estimate->payment_options,
                'shipping_charges'=>$estimate->shipping_charges,
                'due_terms'=>$estimate->due_terms,
                'customer_notes'=>$estimate->customer_notes,
                'termsandconditions'=>$estimate->termsandconditions,
                'email_send'=>$estimate->email_send,
                'recurring_invoices'=>$estimate->recurring_estimates,
                'file_1'=>$estimate->file_1,
                'file_2'=>$estimate->file_2,
                'file_3'=>$estimate->file_3,
                'file_4'=>$estimate->file_4,
            ]);
            
            // Estimated convertd into invoice
            $estimate->is_invoiced = 'yes';
            $estimate->save();

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

            // Send Invoice to the customer, which is converted from estimate into invoice in this method.
            ClientEmailJob::dispatch($invoice, $company_details);
            $message = 'Your invoice has been created and dispatched successfully, you will receive an email shortly!';
            return view('success', compact('message'));
        }
    }

    public function destroy(estimate $estimate)
    {
        EstimateProduct::where('estimate_id', $estimate->id)->delete();
        if ($estimate->delete()) {
            $notification = array(
                'message' => 'Estimate deleted successfully!',
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
