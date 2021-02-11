<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insured;

use Illuminate\Support\Facades\DB;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\SlipTableFileTemp;
use App\Models\CedingBroker;
use App\Models\FeLookupLocation;
use App\Models\MarineLookup;
use App\Models\Customer;
use App\Models\ConditionNeeded;
use App\Models\ConditionNeededTemp;
use App\Models\RouteShip;
use App\Models\Currency;
use App\Models\DeductibleType;
use App\Models\Customer\Customer as CustomerCustomer;
use App\Models\ShipListTemp;
use App\Models\StatusLog;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\InterestInsuredTemp;
use App\Policies\FelookupLocationPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\RetrocessionTemp;
use App\Models\PropertyType;
use App\Models\PropertyTypeTemp;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmarineslip(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip Entry';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        

        if(empty($search))
         {
            $insured = Insured::orderby('id','asc')->get();
            $slip = SlipTable::orderby('id','asc')->get();
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::orderby('id','asc')->get();
            $koc = Koc::orderby('id','asc')->get();
            $ocp = Occupation::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
            $felookup = FelookupLocation::orderby('id','asc')->get();
            $cnd = ConditionNeeded::orderby('id','asc')->get();
            $mlu = MarineLookup::orderby('id','asc')->get();
            
            
            $customer= CustomerCustomer::orderby('id','asc')->get();
            $routeship= RouteShip::orderby('id','asc')->get();
            $interestinsured= InterestInsured::orderby('id','asc')->get();
            $deductibletype= DeductibleType::orderby('id','asc')->get();
            $ms_ids = response()->json($insured->modelKeys());
            $lastid = count($insured);
            $sliplastid = count($slip);

            if($lastid != null){
                if($lastid < 10)
                {
                    $code_ms = "IN" . $mydate . "0000" . strval($lastid + 1);
                }   
                elseif($lastid > 9 && $lastid < 100)
                {
                    $code_ms = "IN" . $mydate . "000" . strval($lastid + 1);
                }
                elseif($lastid > 99 && $lastid < 1000)
                {
                    $code_ms = "IN" . $mydate . "00" . strval($lastid + 1);
                }
                elseif($lastid > 999 && $lastid < 10000)
                {
                    $code_ms = "IN" . $mydate . "0" . strval($lastid + 1);
                }
                elseif($lastid > 9999 && $lastid < 100000)
                {
                    $code_ms = "IN" . $mydate  . strval($lastid + 1);
                }


            }
            else{
                $code_ms = "IN" . $mydate . "0000" . strval(1);
            }

            if($sliplastid != null){
                if($lastid < 10)
                {
                    $code_sl = "M". $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($lastid > 9 && $lastid < 100)
                {
                    $code_sl = "M". $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($lastid > 99 && $lastid < 1000)
                {
                    $code_sl = "M". $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($lastid > 999 && $lastid < 10000)
                {
                    $code_sl = "M". $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($lastid > 9999 && $lastid < 100000)
                {
                    $code_sl = "M". $mydate . strval($sliplastid + 1);
                }

                
            }
            else{
                $code_sl = "M" . $mydate . "0000" . strval(1);
            }

            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $shiplist= ShipListTemp::where('insured_id',$code_ms)->where('status','saved')->orderby('id','desc')->get();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


            return view('crm.transaction.marine_slip', compact(['user','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','deductibletype','interestinsured','routeship','customer','interestlist','shiplist','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         }
        else
        {
          $insured = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($insured->modelKeys());
          return view('crm.transaction.marine_slip', compact('user','customer','slip','insured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }

        
    }

    public function indexhioslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Hole In One - Slip Entry';
        $hio_ids = response()->json($country->modelKeys());

        return view('crm.transaction.hio_slip', compact(['user','route_active','hio_ids']));
    }

    public function indexpaslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Personal Accident - Slip Entry';
        $pa_ids = response()->json($country->modelKeys());

        return view('crm.transaction.pa_slip', compact(['user','route_active','pa_ids']));
    }

    public function indexmarine(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Marine Slip - Index';   
         $mydate = date("Y").date("m").date("d");
         $ms_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'ms')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::with('insureddata')->where('slip_type', '=', 'ms')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

        //   dd($slip);
          return view('crm.transaction.marine_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'ms')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'ms')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());
        
          
        
          return view('crm.transaction.marine_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }

    public function indexhio(Request $request)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Hole In One - Index';   
        $mydate = date("Y").date("m").date("d");
        $hio_ids = response()->json($country->modelKeys());

        $search = @$request->input('search');

            if(empty($search))
            {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
            $insured = Insured::where('slip_type', '=', 'hio')->orderby('id','desc')->paginate(10);
            $insured_ids = response()->json($insured->modelKeys());
            $slip = SlipTable::where('slip_type', '=', 'hio')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($slip->modelKeys());

            return view('crm.transaction.hio_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
            }
            else
            {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
        
            $insured = Insured::where('slip_type', '=', 'hio')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
            $insured_ids = response()->json($insured->modelKeys());
            $slip = SlipTable::where('slip_type', '=', 'hio')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($slip->modelKeys());
        
            return view('crm.transaction.hio_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
            }
    }

    public function indexpa(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Personal Accident - Index';   
         $mydate = date("Y").date("m").date("d");
         $ms_ids = response()->json($country->modelKeys());

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $insured = Insured::where('slip_type', '=', 'pa')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'pa')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

          return view('crm.transaction.pa_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'pa')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());
          $slip = SlipTable::where('slip_type', '=', 'pa')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $slip_ids = response()->json($slip->modelKeys());

        
          return view('crm.transaction.pa_index', compact('user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    public function storemarineinsured(Request $request)
    {
        $validator = $request->validate([
            'msinumber'=>'required',
            'msisuggestinsured'=>'required'
        ]);

        $shiplist= ShipListTemp::where('insured_id','=',$request->msinumber)->where('status','=','pending')->orderby('created_at','desc')->get();
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->msinumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->msinumber,
                    'slip_type'=>'ms',
                    'insured_prefix' => $request->msiprefix,
                    'insured_name'=>$request->msisuggestinsured,
                    'insured_suffix'=>$request->msisuffix,
                    'route'=>$request->msiroute,
                    'route_from'=>$request->msiroutefrom,
                    'route_to'=>$request->msirouteto,
                    'share'=>$request->msishare,
                    'share_from'=>$request->msisharefrom,
                    'share_to'=>$request->msishareto,
                    'ship_detail'=>$shiplist->toJson(),
                    'coincurance'=>$request->msicoinsurance
                ]);

                $notification = array(
                    'message' => 'Marine Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->slip_type='ms';
                $insureddataup->insured_prefix=$request->msiinsured;
                $insureddataup->insured_name=$request->msisuggestinsured;
                $insureddataup->insured_suffix=$request->msisuffix;
                $insureddataup->route=$request->msiroute;
                $insureddataup->route_from=$request->msiroutefrom;
                $insureddataup->route_to=$request->msirouteto;
                $insureddataup->share=$request->msishare;
                $insureddataup->share_from=$request->msisharefrom;
                $insureddataup->share_to=$request->msishareto;
                $insureddataup->ship_detail=$shiplist->toJson();
                $insureddataup->coincurance=$request->msicoinsurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Marine Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }
            dd($shiplist);
            // ShipListTemp::whereIn('id', $shiplist->id)->update(['status' => 'saved']);
            // ShipListTemp::where('status','pending')->delete();

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Marine Insured added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    public function storemarineslip(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required',
            'slipuy'=>'required',
            'slippolicy_no'=>'required',
            'slipno'=>'required',
            'slipcndn'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
            
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $conditionneededlist= ConditionNeededTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             
            $slipfile=SlipTableFile::where('slip_id','=',$request->slipnumber)->orderby('id','desc')->get();             

            if($slipdata==null)
            {
                $currdate = date("Y/m/d");

                SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>Auth::user()->name,
                    'insured_id'=>$request->code_ins,
                    'slip_type'=>'ms',
                    'prod_year' => $currdate,
                    'uy'=>$request->slipuy,
                    'status'=>$request->slipstatus,
                    'endorsment'=>$request->sliped,
                    'selisih'=>$request->slipsls,
                    'source'=>$request->slipcedingbroker,
                    'source_2'=>$request->slipceding,
                    'currency'=>$request->slipcurrency,
                    'cob'=>$request->slipcob,
                    'koc'=>$request->slipkoc,
                    'occupacy'=>$request->slipoccupacy,
                    'build_cost'=>$request->slipbld_const,
                    'slip_no'=>$request->slipno,
                    'cn_dn'=>$request->slipcndn,
                    'policy_no'=>$request->slippolicy_no,
                    'attacment_file'=>$slipfile->toJson(),
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'extend_coverage'=>$conditionneededlist->toJson(),
                    'insurance_period_from'=>$request->slipipfrom,
                    'insurance_perido_to'=>$request->slipipto,
                    'reinsurance_period_from'=>$request->sliprpfrom,
                    'reinsurance_period_to'=>$request->sliprpto,
                    'proportional'=>$request->slipproportional,
                    'layer_non_proportional'=>$request->sliplayerproportional,
                    'rate'=>$request->sliprate,
                    'share'=>$request->slipshare,
                    'sum_share'=>$request->slipsumshare,
                    'basic_premium'=>$request->slipbasicpremium,
                    'commission'=>$request->slipcommission,
                    'grossprm_to_nr'=>$request->slipgrossprmtonr,
                    'netprm_to_nr'=>$request->slipnetprmtonr,
                    'sum_commission'=>$request->slipsumcommission,
                    'installment_panel'=>$installmentlist->toJson(),
                    'retrocession_panel'=>$retrocessionlist->toJson(),
                    'retro_backup'=>$request->sliprb,
                    'own_retention'=>$request->slipor,
                    'sum_own_retention'=>$request->slipsumor
                    

                ]);

                $notification = array(
                    'message' => 'Fire & Engginering Slip added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $currdate = date("Y/m/d");

                $slipdataid=$slipdata->id;
                $slipdataup = SlipTable::findOrFail($slipdataid);
                
                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ins;
                $slipdataup->prod_year=$currdate;
                $slipdataup->uy=$request->slipuy;
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment=$request->sliped;
                $slipdataup->selisih=$request->slipsls;
                $slipdataup->source=$request->slipcedingbroker;
                $slipdataup->source_2=$request->slipceding;
                $slipdataup->currency=$request->slipcurrency;
                $slipdataup->cob=$request->slipcob;
                $slipdataup->koc=$request->slipkoc;
                $slipdataup->occupacy=$request->slipoccupacy;
                $slipdataup->build_cost=$request->slipbld_const;
                $slipdataup->slip_no=$request->slipno; 
                $slipdataup->cn_dn=$request->slipcndn; 
                $slipdataup->policy_no=$request->slippolicy_no; 
                $slipdataup->attacment_file=$slipfile->toJson(); 
                $slipdataup->interest_insured=$interestlist->toJSon();
                $slipdataup->total_sum_insured=$request->sliptotalsum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->extend_coverage=$conditionneededlist->toJson();  
                $slipdataup->insurance_period_from=$request->slipipfrom;  
                $slipdataup->insurance_perido_to=$request->slipipto;  
                $slipdataup->reinsurance_period_from=$request->sliprpfrom;  
                $slipdataup->reinsurance_period_to=$request->sliprpto;
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate;  
                $slipdataup->share=$request->slipshare;
                $slipdataup->sum_share=$request->slipsumshare;
                $slipdataup->basic_premium=$request->slipbasicpremium;
                $slipdataup->commission=$request->slipcommission; 
                $slipdataup->grossprm_to_nr=$request->slipgrossprmtonr; 
                $slipdataup->netprm_to_nr=$request->slipnetprmtonr; 
                $slipdataup->sum_commission=$request->slipsumcommission; 
                $slipdataup->installment_panel=$installmentlist->toJson();   
                $slipdataup->retrocession_panel=$retrocessionlist->toJson();  
                $slipdataup->retro_backup=$request->sliprb;
                $slipdataup->own_retention=$request->slipor;
                $slipdataup->sum_own_retention=$request->slipsumor;

                $slipdataup->save();


                $notification = array(
                    'message' => 'Marine Slip Update successfully!',
                    'alert-type' => 'success'
                );
            }

            StatusLog::create([
                'insured_id'=>$request->code_ins,
                'status'=>$request->slipstatus,
                'datetime'=>date('Y-m-d H:i:s'),
                'slip_id'=>$request->slipnumber,
                'user'=>Auth::user()->name,
            ]);

           

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Marine Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
    }

    


    public function storeshiplist(Request $request)
    {

            $shipcode = $request->ship_code;
            $shipname = $request->ship_name;
            $insured_id = $request->insuredID;
        
            if($shipcode !='' && $shipname !='' && $insured_id != ''){
                $shiplist = new ShipListTemp();
                $shiplist->insured_id = $insured_id;
                $shiplist->ship_code = $shipcode;
                $shiplist->ship_name = $shipname; 
                $shiplist->status = "pending"; 
                $shiplist->save();

                return response()->json($shiplist);
        
            }else{
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );
            }
        
    }

    public function storeinterestlist(Request $request)
    {

            $interest = $request->interest_insured;
            $amount = $request->slipamount;
            $slip_id = $request->id_slip;
        
            if($interest !='' && $amount !='' && $slip_id != ''){
                $interestlist = new InterestInsuredTemp();
                $interestlist->interest_id  = $interest;
                $interestlist->amount = $amount;
                $interestlist->slip_id = $slip_id; 
                $interestlist->save();



                return response()->json(
                    [
                        'id' => $interestlist->id,
                        'interest_id' => $interestlist->interest_id,
                        'amount' => $interestlist->amount,
                        'slip_id' => $interestlist->slip_id,
                        'description' => $interestlist->interestinsured->description
                    ]
                );
        
            }
            else
            {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );
            }
        
    }


    public function storeinstallmentlist(Request $request)
    {

            $percentage = $request->percentage;
            $installmentdate = $request->installmentdate;
            $amount = $request->slipamount;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
                $old_date_timestamp = strtotime($installmentdate);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp); 

                $installmentlist = new InstallmentTemp();
                $installmentlist->installment_date  = $new_date;
                $installmentlist->percentage  = $percentage;
                $installmentlist->amount = $amount;
                $installmentlist->slip_id = $slip_id; 
                $installmentlist->save();

                return response()->json(
                    [
                        'id' => $installmentlist->id,
                        'percentage' => $installmentlist->percentage,
                        'installment_date' => $installmentlist->installment_date,
                        'amount' => $installmentlist->amount,
                        'slip_id' => $installmentlist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }

    public function storedeductiblelist(Request $request)
    {

            $deductibletype_id = $request->slipdptype;
            $currency = $request->slipdpcurrency;
            $minamount = $request->minamount;
            $amount = $request->amount;
            $percentage = $request->percentage;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
                
                $deductiblelist = new DeductibleTemp();
                $deductiblelist->deductibletype_id  = $deductibletype_id;
                $deductiblelist->currency_id  = $currency;
                $deductiblelist->percentage  = $percentage;
                $deductiblelist->amount = $amount;
                $deductiblelist->min_claimamount = $minamount;
                $deductiblelist->slip_id = $slip_id; 
                $deductiblelist->save();

                return response()->json(
                    [
                        'id' => $deductiblelist->id,
                        'deductibletype_id' => $deductiblelist->deductibletype_id,
                        'dtdescript' => $deductiblelist->DeductibleType->description,
                        'dtabbrev' => $deductiblelist->DeductibleType->abbreviation,
                        'percentage' => $deductiblelist->percentage,
                        'currency_id' => $deductiblelist->currency_id,
                        'currencydata' => $deductiblelist->currency->code.'-'.$deductiblelist->currency->symbol_name,
                        'amount' => $deductiblelist->amount,
                        'min_claimamount' => $deductiblelist->min_claimamount,
                        'slip_id' => $deductiblelist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }


    public function storeextendcoveragelist(Request $request)
    {

            $percentage = $request->percentage;
            $slipcncode = $request->slipcncode;
            $amount = $request->amount;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
            
                $extendcoveragelist = new ExtendCoverageTemp();
                $extendcoveragelist->extendcoverage_id  = $slipcncode;
                $extendcoveragelist->percentage  = $percentage;
                $extendcoveragelist->amount = $amount;
                $extendcoveragelist->slip_id = $slip_id; 
                $extendcoveragelist->save();

                return response()->json(
                    [
                        'id' => $extendcoveragelist->id,
                        'percentage' => $extendcoveragelist->percentage,
                        'extendcoverage_id' => $extendcoveragelist->extendcoverage_id,
                        'coveragetype' => $extendcoveragelist->extendcoveragedata->description,
                        'amount' => $extendcoveragelist->amount,
                        'slip_id' => $extendcoveragelist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }

    public function storeconditionneededlist(Request $request)
    {
            
            $slipcncode = $request->slipcncode;
            $cn = ConditionNeeded::where('id',$slipcncode)->first();
            $information = $cn->description;
            $slip_id = $request->id_slip;
        
            if($slipcncode !='' && $slip_id != '')
            {
            
                $conditionneededlist = new ConditionNeededTemp();
                $conditionneededlist->condition_id  = $slipcncode;
                $conditionneededlist->information  = $information;
                $conditionneededlist->slip_id = $slip_id; 
                $conditionneededlist->save();

                return response()->json(
                    [
                        'id' => $conditionneededlist->id,
                        'conditionneeded_id' => $conditionneededlist->condition_id,
                        'condition' => $conditionneededlist->conditionneeded->name,
                        'information' => $conditionneededlist->information,
                        'slip_id' => $conditionneededlist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }

    public function storeretrocessionlist(Request $request)
    {

            $percentage = $request->percentage;
            $contract = $request->contract;
            $type = $request->type;
            $amount = $request->amount;
            $slip_id = $request->id_slip;
        
            if($percentage !='' && $amount !='' && $slip_id != '')
            {
            
                $retrocessionlist = new RetrocessionTemp();
                $retrocessionlist->type  = $type;
                $retrocessionlist->contract  = $contract;
                $retrocessionlist->percentage  = $percentage;
                $retrocessionlist->amount = $amount;
                $retrocessionlist->slip_id = $slip_id; 
                $retrocessionlist->save();

                return response()->json(
                    [
                        'id' => $retrocessionlist->id,
                        'percentage' => $retrocessionlist->percentage,
                        'contract' => $retrocessionlist->contract,
                        'type' => $retrocessionlist->type,
                        'amount' => $retrocessionlist->amount,
                        'slip_id' => $retrocessionlist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }

    public function storepropertytypelist(Request $request)
    {
        
            $property_type_id = $request->property_type_id;
            $slip_id = $request->id_slip;
        
            if($property_type_id !='' && $slip_id != '')
            {
            
                $retrocessionlist = new PropertyTypeTemp();
                $retrocessionlist->property_type_id  = $property_type_id;
                $retrocessionlist->slip_id = $slip_id; 
                $retrocessionlist->save();

                return response()->json(
                    [
                        'id' => $retrocessionlist->id,
                        'propertydata' => $retrocessionlist->propertytypedata->name,
                        'property_type_id' => $retrocessionlist->property_type_id,
                        'slip_id' => $retrocessionlist->slip_id
                    ]
                );
        
            }
            else
            {

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Fill all fields'
                    ]
                );

            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showShipList(Request $request)
    {
        $ship = DB::table("marine_lookup")
        ->where("code",$request->ship_code)
        ->first();
        return response()->json($ship);
    }

    public function showinsureddetails($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        
        $insured = Insured::where('id',$id)->orderby('id','desc')->get();
        // dd($insured);
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
            

        $code_ms = $insured[0]->number;

        
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();
        


        return view('crm.transaction.marine_insured_details', compact(['user','routeship','customer','shiplist','mlu','insured','route_active','ms_ids']));
    }

    public function showslipdetails($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        $slip = SlipTable::where('id',$id)->orderby('id','asc')->get();
        $sl_ids = response()->json($slip->modelKeys());

        $code_sl = $slip[0]->number;
        
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::where('id',$id)->orderby('id','asc')->first();
            $koc = Koc::where('id',$id)->orderby('id','asc')->first();
            $ocp = Occupation::where('id',$id)->orderby('id','asc')->first();
            $cedingbroker = CedingBroker::where('id',$id)->orderby('id','asc')->first();
            $ceding = CedingBroker::where('id',$id)->orderby('id','asc')->where('type','4')->first();
            $felookup = FelookupLocation::where('id',$id)->orderby('id','asc')->get();
            $cnd = ConditionNeeded::where('id',$id)->orderby('id','asc')->get();

            $sliplastid = count($slip);

            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

            return view('crm.transaction.marine_slip_details', compact(['user','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','interestlist','cnd','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','route_active','code_sl','currdate']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editmarineinsured($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Insured Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");
        
        $insured = Insured::where('id',$id)->orderby('id','desc')->get();
        // dd($insured);
        $route = $insured[0]->route;
        $mlu = MarineLookup::orderby('id','asc')->get();
        $customer= CustomerCustomer::orderby('id','asc')->get();
        $routeship= RouteShip::where('id','=',$route)->first();
        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $ms_ids = response()->json($insured->modelKeys());
        $lastid = count($insured);
            

        $code_ms = $insured[0]->number;

        
        $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();
        


        return view('crm.transaction.marine_insured_edit', compact(['user','routeship','customer','shiplist','mlu','insured','route_active','ms_ids']));
    }

    public function editmarineslip($id)
    {
        $user = Auth::user();
        $route_active = 'Marine - Slip Details';
        $mydate = date("Y").date("m").date("d");
        $currdate = date("Y-m-d");

        $slip = SlipTable::where('id',$id)->orderby('id','asc')->get();
        $sl_ids = response()->json($slip->modelKeys());

        $code_sl = $slip[0]->number;
        
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::where('id',$id)->orderby('id','asc')->first();
            $koc = Koc::where('id',$id)->orderby('id','asc')->first();
            $ocp = Occupation::where('id',$id)->orderby('id','asc')->first();
            $cedingbroker = CedingBroker::where('id',$id)->orderby('id','asc')->first();
            $ceding = CedingBroker::where('id',$id)->orderby('id','asc')->where('type','4')->first();
            $felookup = FelookupLocation::where('id',$id)->orderby('id','asc')->get();
            $cnd = ConditionNeeded::where('id',$id)->orderby('id','asc')->get();

            $sliplastid = count($slip);

            $interestlist= InterestInsuredTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $deductibletemp= DeductibleTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $conditionneededtemp= ConditionNeededTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $installmentpanel= InstallmentTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $retrocessiontemp= RetrocessionTemp::where('slip_id',$code_sl)->orderby('id','desc')->get();
            $statuslist= StatusLog::where('slip_id','=',$code_sl)->orderby('id','desc')->get();

            return view('crm.transaction.marine_slip_details', compact(['user','statuslist','retrocessiontemp','installmentpanel','conditionneededtemp','deductibletemp','interestlist','cnd','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','route_active','code_sl','currdate']));
    }
    
    public function updatemarineslip($code_sl)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=CustomerCustomer::orderby('id','asc')->get();

        $currdate = date("Y/m/d");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::orderby('id','asc')->get();
        $koc = KOC::orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','ceding')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ConditionNeeded::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::where('number','=',$code_sl)->firstOrFail();
        $slipdata=SlipTable::where('insured_id','=',$code_sl)->firstOrFail();
        $code_sl=$slipdata->number;

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ConditionNeededTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        // $locationlist= ShipListTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();
        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipupdate', compact(['user','cnd','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    

    public function destroymarineinsured($id)
    {
        $insured = Insured::find($id);
        if($insured->delete())
        {
            

            $notification = array(
                'message' => 'Marine Insured deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroymarineslip($id)
    {
        $insured = SlipTable::find($id);
        if($insured->delete())
        {
            

            $notification = array(
                'message' => 'Marine Insured deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }


    public function updateshiplist(Request $request, ShipListTemp $slt)
   {
    
    $validator = $request->validate([
        'shipcodems'=>'required',
            'shipnamems'=>'required',
            'insured_number'=>'required'
    ]);
    
    if($validator){
        $slt->ship_code = $request->shipcodems;
        $slt->ship_name = $request->shipnamems;
        $slt->save();
        $notification = array(
            'message' => 'Ship List updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyshiplist($id)
    {
        $shiplist = ShipListTemp::find($id);
        $shiplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyinterestlist($id)
    {
        $interestlist = InterestInsuredTemp::find($id);
        
        $amountinterest = $interestlist->amount;
        
        $interestlist->delete();
        
        return response()->json(['success'=>'Data has been deleted','amount'=>$amountinterest]);
    }

    public function destroyinstallmentlist($id)
    {
        $installmentlist = InstallmentTemp::find($id);
        
        $installmentamount = $installmentlist->amount;
        
        $installmentlist->delete();
        
        return response()->json(['success'=>'Data has been deleted','amount'=>$installmentamount]);
    }


    public function destroyextendcoveragelist($id)
    {
        $extendcoveragelist = ExtendCoverageTemp::find($id);
        
        $extendcoveragelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyconditionneededlist($id)
    {
        $extendcoveragelist = ConditionNeededTemp::find($id);
        
        $extendcoveragelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }


    public function destroydeductiblelist($id)
    {
        $deductiblelist = DeductibleTemp::find($id);
        
        $deductiblelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    public function destroyretrocessionlist($id)
    {
        $retrocessionTemplist = RetrocessionTemp::find($id);
        
        $retrocessionTemplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }
    

    public function destroypropertytypelist($id)
    {
        $propertytypeTemplist = PropertyTypeTemp::find($id);
        
        $propertytypeTemplist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

    
    

}
