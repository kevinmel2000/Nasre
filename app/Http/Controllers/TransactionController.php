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
use App\Models\RouteShip;
use App\Models\Currency;
use App\Models\DeductibleType;
use App\Models\Customer\Customer as CustomerCustomer;
use App\Models\ShipListTemp;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\InterestInsuredTemp;
use App\Policies\FelookupLocationPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;


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
            
            $interestlist= InterestInsuredTemp::orderby('id','desc')->get();
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

            $shiplist= ShipListTemp::where('insured_id',$code_ms)->orderby('id','desc')->get();


            return view('crm.transaction.marine_slip', compact(['user','deductibletype','interestinsured','routeship','customer','interestlist','shiplist','cnd','mlu','felookup','currency','cob','koc','ocp','ceding','cedingbroker','slip','insured','route_active','ms_ids','code_ms','code_sl','currdate']));     
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

          return view('crm.transaction.marine_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          
          $insured = Insured::where('slip_type', '=', 'ms')->where('number', 'LIKE', '%' . $search . '%')->orderby('id','desc')->paginate(10);
          $insured_ids = response()->json($insured->modelKeys());

        
          return view('crm.transaction.marine_index', compact('user','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
        
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
            'msiinsured'=>'required',
            'msisuggestinsured'=>'required',
            'msiprefix'=>'required',
            'msisuffix'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->fesnumber)->first();

            if($insureddata==null)
            {
                Insured::create([
                    'number'=>$request->fesnumber,
                    'slip_type'=>'marine',
                    'insured_prefix' => $request->fesinsured,
                    'insured_name'=>$request->fessuggestinsured,
                    'insured_suffix'=>$request->fessuffix,
                    'share'=>$request->fesshare,
                    'share_from'=>$request->fessharefrom,
                    'share_to'=>$request->fesshareto,
                    'coincurance'=>$request->coincurance
                ]);

                $notification = array(
                    'message' => 'Fire & Engginering Insured added successfully!',
                    'alert-type' => 'success'
                );
            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);
                $insureddataup->insured_prefix=$request->fesinsured;
                $insureddataup->insured_name=$request->fessuggestinsured;
                $insureddataup->insured_suffix=$request->fessuffix;
                $insureddataup->share=$request->fesshare;
                $insureddataup->share_from=$request->fessharefrom;
                $insureddataup->share_to=$request->fesshareto;
                $insureddataup->coincurance=$request->coincurance;
                $insureddataup->save();


                $notification = array(
                    'message' => 'Fire & Engginering Insured Update successfully!',
                    'alert-type' => 'success'
                );
            }

           

            return back()->with($notification);
            //Session::flash('Success', 'Fire & Engginering Insured added successfully', 'success');
            //return redirect()->route('liniusaha.index');
        
        }
        else
        {

            $notification = array(
                'message' => 'Fire & Engginering Insured added Failed!',
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
                        'deductibletype' => $deductiblelist->DeductibleType->description,
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


    public function destroydeductiblelist($id)
    {
        $deductiblelist = DeductibleTemp::find($id);
        
        $deductiblelist->delete();
        
        return response()->json(['success'=>'Data has been deleted']);
    }
    

}
