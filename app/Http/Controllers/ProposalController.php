<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\Currency;
use App\Models\Proposal;

use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Models\ProposalProduct;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use App\Jobs\Proposals\ClientEmailJob;

use PDF;
class ProposalController extends Controller
{

    /**
     * @return array of your own company details entered in the office section.
     */
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
        $route_active = 'proposal';
        $user = Auth::user();
        if ($user->role_id != '1') {
            $proposals = Proposal::where('assigned_to',$user->id)->orwhere('created_by_id',$user->id)->orderby('id','desc')->get();
        }else{
            $proposals = Proposal::orderby('id','desc')->get();
        }
        $proposal_ids = response()->json($proposals->modelKeys());

        $company_details = $this->company_details();

        $extraButtons = [];
        foreach ($proposals as $proposal) {
            $extraButtons[$proposal->id] = 'onmouseover="showExtraButtons('.$proposal->id.')" onmouseout="hideExtraButtons('.$proposal->id.')"';
        }

        $productGroups = ProposalProduct::orderby('id','desc')->get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.proposal.index', compact(['route_active', 'proposals','productGroups','base_currency','company_details','proposal_ids', 'extraButtons']));   
    }

    public function proposal_pdf(Proposal $proposal){
       $company_details = $this->company_details();
       $products = $proposal->proposalProducts;
    
     
      $pdf = PDF::loadView('crm.proposal.proposal_pdf', compact('proposal','company_details','products'));

      // download PDF file with download method
      return $pdf->stream('pdf_file.pdf');
    }

    public function create($relation = false, $id=false)
    {   
        $route_active = 'proposalCreate';
        $taxrates = TaxRate::orderby('id','desc')->get();
        $currencies = Currency::orderby('id','desc')->get();
        $users = User::where('role_id','!=','1')->where(['role_id'=>'3'])->orderby('id','desc')->where('status','active')->get();
        $products = Product::where('status','active')->orderby('id','desc')->get();
        return view('crm.proposal.create', compact(['route_active', 'taxrates','currencies','users','products','relation','id']));  
    }

    public function getProduct(Request $request){
        $product= Product::find($request->product_id);
        return response()->json([
            'product_id'=>$request->product_id,
            'product'=>$product
        ]);
    }

    public function getCustomers(){
        $customers= Customer::orderby('id','desc')->get();
        return response()->json([
            'message'=>'success',
            'customers'=>$customers,
        ]);
    }

    public function getLeads(){
        $leads= Lead::orderby('id','desc')->get();
        return response()->json([
            'message'=>'success',
            'leads'=>$leads
        ]);
    }

    public function store(Request $request)
    {
        // Can't send any message to already converted Lead to Customer.
        if($request->relation == 'Lead'){
            $lead = Lead::where(['id'=>$request->lead_customer_id])->first();
            if($lead->leadStatus->name == 'Won'){
                $notification = array(
                    'message' => "You can't add proposal to this lead, its already converted into customer!",
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }
        $validator = $request->validate([
            'subject'=>'required',
        ]);
        if($validator){
            $user = Auth::user();
            $proposal = Proposal::create([
                'subject'=>$request->subject,
                'relation'=>$request->relation,
                'customer_id'=>($request->relation == 'Customer') ? $request->lead_customer_id : NULL,
                'lead_id'=>($request->relation == 'Lead') ? $request->lead_customer_id : NULL,
                'proposal_date'=>$request->proposal_date,
                'open_till_date'=>$request->open_till_date,
                'status'=>$request->status,
                'currency_id'=>$request->currency_id,
                'assigned_to'=>$request->assigned_to,
                'message'=>$request->message,
                'sub_total'=>$request->sub_total,
                'discount_type'=>$request->discount_type,
                'total_discount_percentage'=>$request->total_discount_percentage,
                'discountTotal'=>$request->discountTotal,
                'adjustments'=>$request->adjustments,
                'totalAmount'=>$request->totalAmount,
                'created_by_id'=>$user->id
            ]);

            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    ProposalProduct::create([
                        'proposal_id'=>$proposal->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }    
            if ($request->send_email != null) {
                return $this->mailToClient($proposal);
            }
            $notification = array(
                'message' => 'Proposal submitted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function getProposalProducts(Request $request){
        $proposal_products= ProposalProduct::where(['proposal_id'=>$request->proposal_id])->orderby('id','desc')->get();
        return response()->json([
            'message'=>'success',
            'proposal_products'=>$proposal_products
        ]);        
    }

    public function mailToClient(Proposal $proposal){
        // Update proposal status to sent
        $proposal->status = 'sent';
        $proposal->save();
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
        
        ClientEmailJob::dispatch($proposal, $company_details);
        $notification = array(
            'message' => 'Mail added in the queue successfully and will be sent shortly!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function edit(Proposal $proposal)
    {
        $route_active = 'proposal';
        $taxrates = TaxRate::orderby('id','desc')->get();
        $currencies = Currency::orderby('id','desc')->get();
        $users = User::where('role_id','!=','1')->where(['role_id'=>'3'])->orderby('id','desc')->where('status','active')->get();
        $products = Product::where('status','active')->orderby('id','desc')->get();
        return view('crm.proposal.edit', compact(['route_active', 'taxrates','currencies','users','products','proposal']));  
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validator = $request->validate([
            'subject'=>'required',
        ]);
        if($validator){
     
            $proposal->subject = $request->subject;
            $proposal->relation = $request->relation;
            $proposal->customer_id = ($request->relation == 'Customer') ? $request->lead_customer_id : NULL;
            $proposal->lead_id = ($request->relation == 'Lead') ? $request->lead_customer_id : NULL;
            $proposal->proposal_date = $request->proposal_date;
            $proposal->open_till_date = $request->open_till_date;
            $proposal->status = $request->status;
            $proposal->currency_id = $request->currency_id;
            $proposal->assigned_to = $request->assigned_to;
            $proposal->message = $request->message;
            $proposal->sub_total = $request->sub_total;
            $proposal->discount_type = $request->discount_type;
            $proposal->total_discount_percentage = $request->total_discount_percentage;
            $proposal->discountTotal = $request->discountTotal;
            $proposal->adjustments = $request->adjustments;
            $proposal->totalAmount = $request->totalAmount;
            $proposal->save();

            $proposal_products = ProposalProduct::where(['proposal_id'=>$proposal->id])->delete();


            if($request->product_name != null && count($request->product_name) > 0 ){
                $number_of_products = count($request->product_name);
                for ($i=0; $i < $number_of_products; $i++) { 
                    ProposalProduct::create([
                        'proposal_id'=>$proposal->id,
                        'product_name'=>$request->product_name[$i],
                        'product_price'=>$request->product_price[$i],
                        'product_qty'=>$request->product_qty[$i],
                        'product_tax'=>$request->product_tax[$i],
                        'product_amount'=>$request->product_amount[$i],
                    ]);
                }
            }    
            $notification = array(
                'message' => 'Proposal updated successfully!',
                'alert-type' => 'success'
            );
            return redirect('/proposal')->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(Proposal $proposal)
    {
        ProposalProduct::where('proposal_id', $proposal->id)->delete();
        if ($proposal->delete()) {
            $notification = array(
                'message' => 'Proposal deleted successfully!',
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
