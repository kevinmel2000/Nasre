<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use App\Models\TransLocation;
use App\Models\Currency;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\User;
use App\Models\Insured;
use App\Models\CedingBroker;
use App\Models\TransLocationTemp;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\NatureOfLoss;
use App\Models\MasterCauseOfLoss;
use App\Models\Surveyor;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\PrefixInsured;
use App\Models\MainClaimEntryFAC;
use App\Models\InterestInsuredTemp;
use Illuminate\Support\Facades\Auth;


class Claim_controller extends Controller
{
    public function index()
    {
    	$route_active = 'CLAIM INSURED - Entry';

        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','fe')->orderby('id','asc')->get();
        $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        $surveyor = Surveyor::orderby('id','asc')->get();
        $natureofloss = NatureOfLoss::orderby('id','asc')->get();
        $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();
        $prefixinsured = PrefixInsured::orderby('id','asc')->get();
       
    	return view('crm.transaction.claim.index',compact('prefixinsured','causeofloss','natureofloss','surveyor','ceding','cedingbroker','currency','cob','koc','ocp','route_active'));
    }

    public function indexclaim(Request $request)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'CLAIM INSURED - Index';   

        $mydate = date("Y").date("m").date("d");
        $fe_ids = response()->json($country->modelKeys());
        $search = @$request->input('search');
        $searchinsured = @$request->input('searchinsured');
        $searchuy = @$request->input('searchuy');
        $searchshare = @$request->input('searchshare');
        $searchnre = @$request->input('searchnre');
        $searchtsi = @$request->input('searchtsi');
        $searchendorse = @$request->input('searchendorse');
        $searchslipnum = @$request->input('searchslipnum');
        $searchcob = @$request->input('searchcob');
        $searchceding = @$request->input('searchceding');

        $costumer=Customer::orderby('id','asc')->get();
        
    
       if(!empty($search) || !empty($searchinsured) || !empty($searchuy) || !empty($searchshare) || !empty($searchnre) || !empty($searchtsi) || !empty($searchendorse))
       {

           $query = Insured::query();

           if (!empty($search)) {
               $query = $query->where('number', $search);
           }

           if (!empty($searchinsured)) {
               $query = $query->where('insured_name', $searchinsured);
           }

           if (!empty($searchuy)) {
               $query = $query->where('uy', $searchuy);
           }

           if (!empty($searchshare)) {
               $query = $query->where('share', $searchshare);
           }

           if (!empty($searchnre)) {
               $query = $query->where('share_from', $searchnre);
           }

           if (!empty($searchtsi)) {
               $query = $query->where('share_to', $searchtsi);
           }

           if (!empty($searchendorse)) {
               $query = $query->where('count_endorsement', $searchendorse);
           }

           // Ordering
           $query = $query->where('slip_type', '=', 'fe')->orderBy('id', 'DESC');
           
           $insured =$query->paginate(50);
           $insured_ids = response()->json($insured->modelKeys());
   

           $cob = COB::orderby('id','asc')->get();
           $cedingbroker = CedingBroker::orderby('id','asc')->get();
           $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();
           $currency = Currency::orderby('id','asc')->get();
           $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
           $ocp = Occupation::orderby('id','asc')->get();
          
           $surveyor = Surveyor::orderby('id','asc')->get();
           $natureofloss = NatureOfLoss::orderby('id','asc')->get();
           $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();

           $claimlist= Insured::where('statmodified','=',1)->whereNull('share_to')->Where('share_to','=',0)->get();

           return view('crm.transaction.claim.claim_index', compact('claimlist','costumer','causeofloss','natureofloss','surveyor','ocp','koc','currency','searchslipnum','searchcob','searchceding','search','searchinsured','searchuy','searchshare','searchnre','searchtsi','searchendorse','cob','cedingbroker','ceding','user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
           
        }
        else
        {
           //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
           
           //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
           $insured = Insured::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
           $insured_ids = response()->json($insured->modelKeys());
           

           $cob = COB::orderby('id','asc')->get();
           $cedingbroker = CedingBroker::orderby('id','asc')->get();
           $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();
           $currency = Currency::orderby('id','asc')->get();
           $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
           $ocp = Occupation::orderby('id','asc')->get();

           $surveyor = Surveyor::orderby('id','asc')->get();
           $natureofloss = NatureOfLoss::orderby('id','asc')->get();
           $causeofloss = MasterCauseOfLoss::orderby('id','asc')->get();

           $claimlist= Insured::where('statmodified','=',1)->whereNull('share_to')->Where('share_to','=',0)->get();

           return view('crm.transaction.claim.claim_index', compact('claimlist','costumer','causeofloss','natureofloss','surveyor','ocp','koc','currency','searchslipnum','searchcob','searchceding','search','searchinsured','searchuy','searchshare','searchnre','searchtsi','searchendorse','cob','cedingbroker','ceding','user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
           
       }

    }

    public function storeclaiminsured(Request $request)
    {
        
        $validator = $request->validate([
            'number'=>'required',
            'regcomp'=>'required',
            'dateofreceipt'=>'required',
            'dateofdocument'=>'required',
            'causeofloss'=>'required',
            'desccauseofloss'=>'required',
            'natureofloss'=>'required',
            'descnatureofloss'=>'required',
        ]);
        
        if($validator)
        {
            //dd($request);
            //exit();
            
            $user = Auth::user();
            MainClaimEntryFAC::create([
                'number'=>$request->number,
                'reg_comp'=> $request->regcomp,
                'date_receipt'=> date("Y-m-d", strtotime($request->dateofreceipt)),
                'date_document'=> date("Y-m-d", strtotime($request->dateofdocument)),
                'causeofloss_id'=> $request->causeofloss,
                'desc_causeofloss'=> $request->desccauseofloss,
                'natureofloss_id'=> $request->natureofloss,
                'descnatureofloss'=> $request->descnatureofloss,
                'date_of_loss'=> $request->dateofloss,
                'curr_id_loss'=>$request->currofloss,
                'curr_lossdesc'=>$request->desccurrofloss,
                'surveyor_id'=>$request->surveyoradjuster,
                'desc_surveyor'=>$request->descsurveyoradjuster,
            ]);

            $notification = array(
                'message' => 'Main Claim added successfully!',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }

}

