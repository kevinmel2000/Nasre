<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insured;
use App\Models\Currency;
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
use App\Models\Customer\Customer as CustomerCustomer;
use App\Models\ShipListTemp;
use App\Models\InterestInsured;
use App\Policies\FelookupLocationPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $currdate = date("Y/m/d");
        

        if(empty($search))
         {
            $insured = Insured::orderby('id','asc')->get();
            $slip = SlipTable::orderby('id','asc')->get();
            $currency = Currency::orderby('id','asc')->get();
            $cob = COB::orderby('id','asc')->get();
            $koc = Koc::orderby('id','asc')->get();
            $ocp = Occupation::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type','ceding')->get();
            $felookup = FelookupLocation::orderby('id','asc')->get();
            $cnd = ConditionNeeded::orderby('id','asc')->get();
            $mlu = MarineLookup::orderby('id','asc')->get();
            $shiplist= ShipListTemp::orderby('id','desc')->get();
            $interestlist= InterestInsured::orderby('id','desc')->get();
            $customer= CustomerCustomer::orderby('id','asc')->get();
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


            return view('crm.transaction.marine_slip', compact(['user','customer','interestlist','shiplist','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
         }
        else
        {
          $insured = Insured::where('number', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $ms_ids = response()->json($insured->modelKeys());
          return view('crm.transaction.marine_slip', compact('user','customer','slip','insured','route_active','ms_ids','code_ms'))->with('i', ($request->input('page', 1) - 1) * 10);
        }

        
    }

    public function indexfeslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $fe_ids = response()->json($country->modelKeys());


        return view('crm.transaction.fe_slip', compact(['user','route_active','fe_ids']));
    }

    public function indexflslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Financial Lines - Slip Entry';
        $fl_ids = response()->json($country->modelKeys());

        return view('crm.transaction.fl_slip', compact(['user','route_active','fl_ids']));
    }

    public function indexmpslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Moveable Property - Slip Entry';
        $mp_ids = response()->json($country->modelKeys());

        return view('crm.transaction.mp_slip', compact(['user','route_active','mp_ids']));
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

    public function indexhemslip()
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'HE & Motor - Slip Entry';
        $hem_ids = response()->json($country->modelKeys());

        return view('crm.transaction.hem_slip', compact(['user','route_active','hem_ids']));
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
        //
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
                $interestlist = new InterestInsured();
                $interestlist->interest  = $interest;
                $interestlist->amount = $amount;
                $interestlist->slip_id = $slip_id; 
                $interestlist->save();

                return response()->json($interestlist);
        
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
    public function storemarineslip(Request $request)
    {
        //
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
        $interestlist = InterestInsured::find($id);
        $interestlist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }

}
