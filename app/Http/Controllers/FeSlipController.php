<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Customer\Customer;
use App\Models\FeLookupLocation;
use App\Models\SlipTable;
use App\Models\SlipTableFile;
use App\Models\SlipTableFileTemp;
use App\Models\TransLocation;
use App\Models\Currency;
use App\Models\COB;
use App\Models\Occupation;
use App\Models\Koc;
use App\Models\CedingBroker;
use App\Models\ConditionNeeded;
use App\Models\ShipListTemp;
use App\Policies\FelookupLocationPolicy;
use App\Models\TransLocationTemp;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Models\Insured;
use App\Models\InterestInsured;
use App\Models\InstallmentTemp;
use App\Models\InterestInsuredTemp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ExtendCoverageTemp;
use App\Models\DeductibleTemp;
use App\Models\StatusLog;
use App\Models\RetrocessionTemp;
use App\Models\RiskLocationDetail;
use App\Models\CurrencyExchange;
use App\Models\InsuredNumber;
use App\Models\SlipNumber;


class FeSlipController extends Controller
{

    public function getCountries(){
        $countries = DB::table('countries')->get();
        return response()->json([
            'message'=>'success',
            'countries'=>$countries
        ]);
    }

    public function getStates(Request $request, $id){
        if($request->ajax())
            return DB::table('states')->where(['country_id'=> $id])->get();
        else{
            return 0;
        }
    } 
    
    public function getCities(Request $request, $id){
        if($request->ajax())
            return DB::table('cities')->where(['state_id'=> $id])->get();
        else{
            return 0;
        }
    }

    public function getStateList(Request $request)
    {
        $states = DB::table("states")
        ->where("country_id",$request->country_id)
        ->pluck("name","id");
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $cities = DB::table("cities")
        ->where("state_id",$request->state_id)
        ->pluck("name","id");
        return response()->json($cities);
    }

    public function getStateLookup(Request $request)
    {
        $statestable = collect( DB::table("fe_lookup_location")
        ->join('states', 'fe_lookup_location.province_id', '=', 'states.id')
        ->where("fe_lookup_location.country_id","=",$request->country_id)
        ->pluck("states.name","fe_lookup_location.province_id"));

        //$statestable2 = $statestable->unique('fe_lookup_location.province_id');
        $statestable->values()->all();

        return response()->json($statestable);
    }

    public function getCityLookup(Request $request)
    {
        // $cities = DB::table("fe_lookup_location")
        // ->join('cities', 'fe_lookup_location.city_id', '=', 'cities.id')
        // ->where("fe_lookup_location.province_id",$request->state_id)
        // ->pluck("cities.name","fe_lookup_location.city_id");
        $citiestable = collect(DB::table("fe_lookup_location")
        ->join('cities', 'fe_lookup_location.city_id', '=', 'cities.id')
        ->where("fe_lookup_location.province_id",$request->state_id)
        ->pluck("cities.name","fe_lookup_location.city_id"));
        
        //$cities = $citiestable->unique('fe_lookup_location.province_id');
        $citiestable->values()->all();
        return response()->json($citiestable);
    }

    
    public function getAddressLookup(Request $request)
    {
        $address = DB::table("fe_lookup_location")
        ->where("city_id",$request->city_id)
        ->pluck("address","id");
        return response()->json($address);
    }


    public function getCostumers(Request $request){

        $search = $request->search;
  
        if($search == ''){
           $costumers = Customer::orderby('company_name','asc')->select('id','company_name')->limit(10)->get();
        }else{
           $costumers = Customer::orderby('company_name','asc')->select('id','company_name')->where('company_name', 'like', '%' .$search . '%')->limit(10)->get();
        }
  
        $response = array();
        foreach($costumers as $costumer){
           $response[] = array("value"=>$costumer->id,"label"=>$costumer->company_name);
        }
  
        return response()->json($response);
     }


     public function getBuildingRate(Request $request){

        $building_rate = $request->building;
        $ocp_id = $request->occupacy_id;
  
        if($building_rate == "Building 1"){
           $rate_building = Occupation::select('id','rate_batas_atas_building_class_1','rate_batas_bawah_building_class_1')->where('id',$ocp_id)->first();
        }elseif($building_rate == "Building 2"){
            $rate_building = Occupation::select('id','rate_batas_atas_building_class_2','rate_batas_bawah_building_class_2')->where('id',$ocp_id)->first();
        }elseif($building_rate == "Building 3"){
            $rate_building = Occupation::select('id','rate_batas_atas_building_class_3','rate_batas_bawah_building_class_3')->where('id',$ocp_id)->first();
        }
  
        return response()->json($rate_building);
     }


     public function getCurrencyKurs(Request $request)
     {

        $search = $request->search;
  
        //CurrencyExchange
       
        if($search == ''){
           $currency = Currency::where('code', '=', $search)->first();
        }
        else
        {
           $currency = Currency::where('code', '=', 'IDR')->where('country','=','102')->first();
        }
  
        $response = array();
        foreach($currency as $cy){
           $response[] = array("value"=>$cy->id,"label"=>$cy->code);
        }
  
        return response()->json($response);
     }



     public function getCedingDetail(Request $request){

        $ceding_id = $request->ceding_id;
        $insured_id = $request->insured_id;
        $ceding = CedingBroker::where('id', $ceding_id)->first();
        // $ocp_id = $request->occupacy_id;
  
        if($ceding->type == 4){
           $ceding_list = CedingBroker::select('id','code','name','type')->where('id',$ceding_id)->first();
           $risklocation_detail = RiskLocationDetail::where('ceding_id',$ceding->id)->get();
           $amount_list = count($risklocation_detail);

           $sum_amount = DB::table('risk_location_detail')
                            ->join('trans_location_detail','trans_location_detail.id','=','risk_location_detail.translocation_id')
                            ->where('trans_location_detail.insured_id',$insured_id)->where('risk_location_detail.ceding_id',$ceding->id)
                            ->sum('risk_location_detail.amountlocation');
            // dd($sum_amount);
           return response()->json(['id' => $ceding_list->id,
                                    'code' => $ceding_list->code,
                                    'name'=> $ceding_list->name,
                                    'type'=>$ceding_list->type,
                                    'amountlist'=>$amount_list,
                                    'sumamount'=>$sum_amount
                                    ]);
        }else{
            $ceding_list = CedingBroker::select('id','code','name','type')->where('type',4)->get();

            return response()->json($ceding_list);
        }
  
        
     }

     public function getsumAmount(Request $request)
     {
        $ceding_id = $request->ceding_id;
        $insured_id = $request->insured_id;
        $ceding = CedingBroker::where('id', $ceding_id)->first();
        // $ocp_id = $request->occupacy_id;
  
        if($ceding->type == 4){
           $ceding_list = CedingBroker::select('id','code','name','type')->where('id',$ceding_id)->first();
           $risklocation_detail = RiskLocationDetail::where('ceding_id',$ceding->id)->get();
           $amount_list = count($risklocation_detail);
           $sum_amount = DB::table('risk_location_detail')
                            ->join('trans_location_detail','trans_location_detail.id','=','risk_location_detail.translocation_id')
                            ->where('trans_location_detail.insured_id',$insured_id)->where('risk_location_detail.ceding_id',$ceding->id)
                            ->sum('risk_location_detail.amountlocation');
            // dd($sum_amount);
           return response()->json(['id' => $ceding_list->id,
                                    'code' => $ceding_list->code,
                                    'name'=> $ceding_list->name,
                                    'type'=>$ceding_list->type,
                                    'amountlist'=>$amount_list,
                                    'sumamount'=>$sum_amount
                                    ]);
        }
        else
        {
            $ceding_list = CedingBroker::select('id','code','name','type')->where('type',4)->get();

            return response()->json($ceding_list);
        }
  
        
     }
    
    public function index(Request $request)
    {
         $user = Auth::user();
         $country = User::orderby('id','asc')->get();
         $route_active = 'Fire Engineering - Index';   
         $mydate = date("Y").date("m").date("d");
         $fe_ids = response()->json($country->modelKeys());
         $search = @$request->input('search');
         
        $checkdatainsured= Insured::where('statmodified','=',1)->whereNull('share_to')->Where('share_to','=',0)->get();

        foreach ($checkdatainsured as $insureddata)
        {   
            //$deleteinsured= SlipTable::where('insured_id','=',$insureddata->number)->delete();
            $deleteinsured= Insured::where('number','=',$insureddata->number)->delete();  
        }

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
    
            $slip = SlipTable::where('slip_type', '=', 'fe')->orWhere('number', 'LIKE', '%' . @$search . '%')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($insured->modelKeys());

            $insuredlist=[];
            foreach (@$insured as $insureddata)
            {
                   $queryslip = SlipTable::query();
                   
                   if (!empty($searchslipnum)) 
                   {
                    $queryslip = $queryslip->where('number', $searchslipnum);
                   }

                   if (!empty($searchcob)) 
                   {
                    $queryslip = $queryslip->where('cob', $searchcob);
                   }

                   if (!empty($searchceding)) 
                   {
                    $queryslip = $queryslip->where('source', $searchceding);
                   }

                   $slipdata=$queryslip->where('insured_id', '=', $insureddata->number)->get()->toArray();
                   
                   $sliplist=[];
                   foreach($slipdata as $value)
                   {
                     $value['cobdata']=COB::where('id','=',$value['cob'])->first();
                     $value['brokerdata']=CedingBroker::where('id','=',$value['source'])->first();
                     $value['cedingdata']=CedingBroker::where('id','=',$value['source_2'])->first();

                     array_push($sliplist,$value);
                   }
                
                   $insureddata->slipdata=$sliplist;
                
                if(!empty($sliplist))
                {
                  array_push($insuredlist,$insureddata);
                }
            }

            $cob = COB::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();

            return view('crm.transaction.fe_slip_index', compact('cob','cedingbroker','ceding','insuredlist','user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
            
         }
         else
         {
            //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
            
            //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
            $insured = Insured::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
            $insured_ids = response()->json($insured->modelKeys());
            $slip = SlipTable::where('slip_type', '=', 'fe')->orderby('id','desc')->paginate(10);
            $slip_ids = response()->json($insured->modelKeys());
            
            $insuredlist=[];
            foreach (@$insured as $insureddata)
            {
                    $slipdata=SlipTable::where('insured_id', '=', $insureddata->number)->get()->toArray();
                    
                    $sliplist=[];
                    foreach($slipdata as $value)
                    {
                    $value['cobdata']=COB::where('id','=',$value['cob'])->first();
                    $value['brokerdata']=CedingBroker::where('id','=',$value['source'])->first();
                    $value['cedingdata']=CedingBroker::where('id','=',$value['source_2'])->first();

                    array_push($sliplist,$value);
                    }
                
                    $insureddata->slipdata=$sliplist;
                
                array_push($insuredlist,$insureddata);
            }

            //print_r($insuredlist);
            //exit();
            //$insured=$insuredlist;

            $cob = COB::orderby('id','asc')->get();
            $cedingbroker = CedingBroker::orderby('id','asc')->get();
            $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();

            return view('crm.transaction.fe_slip_index', compact('cob','cedingbroker','ceding','insuredlist','user','slip','slip_ids','insured','insured_ids','route_active','country'))->with('i', ($request->input('page', 1) - 1) * 10);
            
        }
    }


    public function indexfeslip()
    {
        $user = Auth::user();
        $userid = Auth::user()->id;
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
        $currdate2 = date("Y-m-d");
        // $currdate = date("d/m/Y");
        $insured = Insured::orderby('id','asc')->get();
        // $insured_now = Insured::whereDate('created_at',$currdate2)->orderby('id','asc')->get();
        $insured_now = InsuredNumber::whereDate('created_at',$currdate2)->orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::where('form','fe')->orderby('id','asc')->get();
        $koc = Koc::where('parent_id',2)->orWhere('code', 'like',  02 . '%')->orderby('code','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','4')->get();
        // $felookup = FelookupLocation::distinct()->orderby('id','asc')->get();
        $felookuptable = collect(FelookupLocation::orderby('id','asc')->get());
        $felookup = $felookuptable->unique('country_id');
        $felookup->values()->all();
        
        // $felookup = DB::table('fe_lookup_location')
        //             ->join('countries','countries.id','=','fe_lookup_location.country_id')
        //             ->select('fe_lookup_location.*','countries.code','countries.name')        
        //             ->orderby('id','asc')
        //             ->distinct('fe_lookup_location.country_id')
        //             ->get();
        
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        $lastid = count($insured_now);
        

        if($lastid != null)
        {
            if($lastid < 9)
            {
                $code_ms = "IN". $mydate . "0000" . strval($lastid + 1);
            }   
            elseif($lastid > 8 && $lastid < 99)
            {
                $code_ms = "IN". $mydate . "000" . strval($lastid + 1);
            }
            elseif($lastid > 98 && $lastid < 999)
            {
                $code_ms = "IN". $mydate . "00" . strval($lastid + 1);
            }
            elseif($lastid > 998 && $lastid < 9999)
            {
                $code_ms = "IN". $mydate . "0" . strval($lastid + 1);
            }
            elseif($lastid > 9998 && $lastid < 99999)
            {
                $code_ms = "IN". $mydate  . strval($lastid + 1);
            }
        }
        else{
            $code_ms = "IN" . $mydate . "0000" . strval(1);
        }


        
        // $kondisi=0;
        // $im=1;
        // while($kondisi==0)
        // {
        //         $checkinsured = Insured::where('number',$code_ms)->first();
                
        //         if(!empty($checkinsured))
        //         {
                    
        //             $newnumber2 = substr($code_ms, 10,15);
        //             $codenumber = substr($code_ms, 0,10);

        //             if(intval($newnumber2) < 9)
        //             {
        //                 $count = substr($newnumber2,14);
        //                 $code_ms = $codenumber . "0000" . strval(intval($count) + $im);
        //             }   
        //             elseif(intval($newnumber2) > 8 && intval($newnumber2) < 99)
        //             {
        //                 $count = substr($newnumber2,13);
        //                 $code_ms = $codenumber . "000" . strval(intval($count) + $im);
        //             }
        //             elseif(intval($newnumber2) > 98 && intval($newnumber2) < 999)
        //             {
        //                 $count = substr($newnumber2,12);
        //                 $code_ms = $codenumber . "00" . strval(intval($count) + $im);
        //             }
        //             elseif(intval($newnumber2) > 998 && intval($newnumber2) < 9999)
        //             {
        //                 $count = substr($newnumber2,11);
        //                 $code_ms = $codenumber . "0" . strval(intval($count) + $im);
        //             }
        //             elseif(intval($newnumber2) > 9998 && intval($newnumber2) < 99999)
        //             {
        //                 $count = substr($newnumber2,10);
        //                 $code_ms = $codenumber  . strval(intval($count) + $im);
        //             }
                    
        //             $im++;
        //         }
        //         else
        //         {
        //             $kondisi=1;
        //         }
        // }

        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();
        // $slip_now = SlipTable::whereDate('created_at',$currdate2)->where('slip_type','fe')->where('insured_id',$code_ms)->orderby('id','asc')->get();
        $slip_now = SlipNumber::whereDate('created_at',$currdate2)->where('slip_type','fe')->where('insured_number',$code_ms)->orderby('id','asc')->get();
        $sliplastid = count($slip_now);
        // dd($sliplastid);

        if($sliplastid != null)
                {
                    if($sliplastid < 9)
                    {
                        $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + 1);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 99)
                    {
                        $code_sl = "FE".  $mydate . "000" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 98 && $sliplastid < 999)
                    {
                        $code_sl = "FE".  $mydate . "00" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 998 && $sliplastid < 9999)
                    {
                        $code_sl = "FE".  $mydate . "0" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 9998 && $sliplastid < 99999)
                    {
                        $code_sl = "FE".  $mydate . strval($sliplastid + 1);
                    }

                    
                }
                else
                {
                    $code_sl = "FE".  $mydate . "0000" . strval(1);
                }

                

        
        // $kondisi=0;
        // $im=1;
        // while($kondisi==0)
        // {
        //     $checkdataslip= SlipTable::where('number',$code_sl)->first();

        //     if(!empty($checkdataslip))
        //     {
        //         $newnumber2 = substr($code_sl, 10,15);
        //         $codenumber = substr($code_sl, 0,10);

        //         if(intval($newnumber2) < 9)
        //         {
        //             $count = substr($newnumber2,14);
        //             $code_sl = $codenumber . "0000" . strval(intval($count) + $im);
        //         }   
        //         elseif(intval($newnumber2) > 8 && intval($newnumber2) < 99)
        //         {
        //             $count = substr($newnumber2,13);
        //             $code_sl = $codenumber . "000" . strval(intval($count) + $im);
        //         }
        //         elseif(intval($newnumber2) > 98 && intval($newnumber2) < 999)
        //         {
        //             $count = substr($newnumber2,12);
        //             $code_sl = $codenumber . "00" . strval(intval($count) + $im);
        //         }
        //         elseif(intval($newnumber2) > 998 && intval($newnumber2) < 9999)
        //         {
        //             $count = substr($newnumber2,11);
        //             $code_sl = $codenumber . "0" . strval(intval($count) + $im);
        //         }
        //         elseif(intval($newnumber2) > 9998 && intval($newnumber2) < 99999)
        //         {
        //             $count = substr($newnumber2,10);
        //             $code_sl = $codenumber  . strval(intval($count) + $im);
        //         }
                
        //         $im++;
        //     }
        //     else
        //     {
        //         $kondisi=1;
        //     }    
        // }

        $checkinsurednumber = InsuredNumber::where('number',$code_ms)->first();
        $insurednumform = '';
        if($checkinsurednumber != null){
            if($code_ms != $checkinsurednumber->number ){
                $reservedinsurednumber = InsuredNumber::create([
                            'number'=>$code_ms,
                            'status'=>'passive'     
                ]);

                $insurednumform = $reservedinsurednumber->number;

                //slip number
                $checkslipnumber= SlipNumber::where('number',$code_sl)->first();

                
                $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number'=>$code_ms     
                    ]);

                $interestinsured= InterestInsured::orderby('id','asc')->get();
                $locationid = TransLocationTemp::select('id')->where('insured_id','=',$code_ms)->orderby('id','desc')->get();
                foreach($locationid as $dataid)
                {
                    RiskLocationDetail::where('translocation_id','=',$dataid->id)->delete();
                }
                
                // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $locationlist = TransLocationTemp::where('insured_id','=',$code_ms)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();

                // $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


                // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();

                
                $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->where('slip_type','fe')->orderby('id','desc')->get();

                
                $locationlist=array();
                foreach($locationlist2 as $datadetail)
                {
                    if($datadetail->risklocationdetail){
                        $datadetail->risklocationdetail = RiskLocationDetail::where('translocation_id','=',$datadetail->id)->delete();
                        
                    }else{
                        $datadetail->risklocationdetail= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->orderby('id','desc')->get();
                    }
                    $locationlist[]= $datadetail;
                }


                $statuslist= StatusLog::where('insured_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                
                // if(count($interestlist) != null){
                //     InterestInsuredTemp::where('slip_id', $code_sl)->delete();
                // }

                // if(count($locationlist) != null){
                //     TransLocationTemp::where('insured_id', $code_ms)->delete();
                // }

                return view('crm.transaction.fe_slip', compact(['insurednumform','user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));


                
            }else{
                 if($checkinsurednumber->status == 'passive'){
                    InsuredNumber::where('number','=',$code_ms)->orderby('id','desc')->delete();

                     $reservedinsurednumber = InsuredNumber::create([
                                'number'=>$code_ms,
                                'status'=>'passive'     
                    ]);

                    $insurednumform = $reservedinsurednumber->number;

                     
                    

                    $checkslipnumber= SlipNumber::where('number',$code_sl)->first();

                    $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number'=>$code_ms       
                    ]);

                    $interestinsured= InterestInsured::orderby('id','asc')->get();
                    $locationid = TransLocationTemp::select('id')->where('insured_id','=',$code_ms)->orderby('id','desc')->get();
                    foreach($locationid as $dataid)
                    {
                        RiskLocationDetail::where('translocation_id','=',$dataid->id)->delete();
                    }
                    
                    // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $locationlist = TransLocationTemp::where('insured_id','=',$code_ms)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();

                    // $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


                    // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();

                
                    $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->where('slip_type','fe')->orderby('id','desc')->get();

                    
                    $locationlist=array();
                    foreach($locationlist2 as $datadetail)
                    {
                        if($datadetail->risklocationdetail){
                            $datadetail->risklocationdetail = RiskLocationDetail::where('translocation_id','=',$datadetail->id)->delete();
                            
                        }else{
                            $datadetail->risklocationdetail= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->orderby('id','desc')->get();
                        }
                        $locationlist[]= $datadetail;
                    }


                    $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
                    
                    // if(count($interestlist) != null){
                    //     InterestInsuredTemp::where('slip_id', $code_sl)->delete();
                    // }

                    // if(count($locationlist) != null){
                    //     TransLocationTemp::where('insured_id', $code_ms)->delete();
                    // }

                    return view('crm.transaction.fe_slip', compact(['insurednumform','user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));


                       

                 }elseif($checkinsurednumber->status == 'active'){
                    $newnumber2 = substr($code_ms, 10,15);
                    $codenumber = substr($code_ms, 0,10);

                    if(intval($newnumber2) < 9)
                    {
                        $count = substr($newnumber2,14);
                        $code_ms2 = $codenumber . "0000" . strval(intval($count) + 1);
                    }   
                    elseif(intval($newnumber2) > 8 && intval($newnumber2) < 99)
                    {
                        $count = substr($newnumber2,13);
                        $code_ms2 = $codenumber . "000" . strval(intval($count) + 1);
                    }
                    elseif(intval($newnumber2) > 98 && intval($newnumber2) < 999)
                    {
                        $count = substr($newnumber2,12);
                        $code_ms2 = $codenumber . "00" . strval(intval($count) + 1);
                    }
                    elseif(intval($newnumber2) > 998 && intval($newnumber2) < 9999)
                    {
                        $count = substr($newnumber2,11);
                        $code_ms2 = $codenumber . "0" . strval(intval($count) + 1);
                    }
                    elseif(intval($newnumber2) > 9998 && intval($newnumber2) < 99999)
                    {
                        $count = substr($newnumber2,10);
                        $code_ms2 = $codenumber  . strval(intval($count) + 1);
                    }


                    $reservedinsurednumber = InsuredNumber::create([
                                'number'=>$code_ms2,
                                'status'=>'passive'     
                    ]);

                    $insurednumform = $reservedinsurednumber->number;

                    
                    $checkslipnumber= SlipNumber::where('number',$code_sl)->first();

                    $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number'=>$code_ms       
                    ]);

                    $interestinsured= InterestInsured::orderby('id','asc')->get();
                    $locationid = TransLocationTemp::select('id')->where('insured_id','=',$code_ms)->orderby('id','desc')->get();
                    foreach($locationid as $dataid)
                    {
                        RiskLocationDetail::where('translocation_id','=',$dataid->id)->delete();
                    }
                    
                   // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $locationlist = TransLocationTemp::where('insured_id','=',$code_ms)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                    $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();

                    // $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


                    // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                    $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();

                    
                    $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->where('slip_type','fe')->orderby('id','desc')->get();

                    
                    $locationlist=array();
                    foreach($locationlist2 as $datadetail)
                    {
                        if($datadetail->risklocationdetail){
                            $datadetail->risklocationdetail = RiskLocationDetail::where('translocation_id','=',$datadetail->id)->delete();
                            
                        }else{
                            $datadetail->risklocationdetail= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->orderby('id','desc')->get();
                        }
                        $locationlist[]= $datadetail;
                    }


                    $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
                    
                    // if(count($interestlist) != null){
                    //     InterestInsuredTemp::where('slip_id', $code_sl)->delete();
                    // }

                    // if(count($locationlist) != null){
                    //     TransLocationTemp::where('insured_id', $code_ms)->delete();
                    // }

                    return view('crm.transaction.fe_slip', compact(['insurednumform','user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));


                    
                    

                    
                 }
            }
        }
        else
        {
            $reservedinsurednumber = InsuredNumber::create([
                            'number'=>$code_ms,
                            'status'=>'passive'     
                ]);

                $insurednumform = $reservedinsurednumber->number;

                

                $checkslipnumber= SlipNumber::where('number',$code_sl)->first();

                $slipnumform = '';
                $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number'=>$code_ms       
                    ]);

                $interestinsured= InterestInsured::orderby('id','asc')->get();
                $locationid = TransLocationTemp::select('id')->where('insured_id','=',$code_ms)->orderby('id','desc')->get();
                foreach($locationid as $dataid)
                {
                    RiskLocationDetail::where('translocation_id','=',$dataid->id)->delete();
                }
                
                // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $locationlist = TransLocationTemp::where('insured_id','=',$code_ms)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
                $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();

                // $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


                // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();

                
                $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->where('slip_type','fe')->orderby('id','desc')->get();

                
                $locationlist=array();
                foreach($locationlist2 as $datadetail)
                {
                    if($datadetail->risklocationdetail){
                        $datadetail->risklocationdetail = RiskLocationDetail::where('translocation_id','=',$datadetail->id)->delete();
                        
                    }else{
                        $datadetail->risklocationdetail= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->orderby('id','desc')->get();
                    }
                    $locationlist[]= $datadetail;
                }


                $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
                
                // if(count($interestlist) != null){
                //     InterestInsuredTemp::where('slip_id', $code_sl)->delete();
                // }

                // if(count($locationlist) != null){
                //     TransLocationTemp::where('insured_id', $code_ms)->delete();
                // }

                return view('crm.transaction.fe_slip', compact(['insurednumform','user','cnd','slipdata','slipdata2','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));

                
        }        
    }


    public function updatefeslip($idm)
    {
        $user = Auth::user();
        //print_r($user);
        //exit();
        $userid = Auth::user()->id;
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::orderby('id','asc')->get();
        $koc = KOC::where('parent_id',2)->orWhere('id',2)->orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type',4)->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        // dd($insureddata->number);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id',$insureddata->number)->where('endorsment',$insureddata->count_endorsement)->first();
        $slipdata2=SlipTable::where('insured_id',$insureddata->number)->where('endorsment',$insureddata->count_endorsement)->get();
        // dd($slipdata2);

        if(!empty($slipdata))
        {      
                $code_sl=$slipdata->number;
                $slip = SlipTable::orderby('id','asc')->get();
                $slip_now = SlipTable::whereDate('created_at',$currdate)->where('slip_type','fe')->orderby('id','asc')->get();
                $sliplastid = count($slip_now);
                
                $kondisi=false;
                $i=1;
                while($kondisi==false)
                {
                    $slipdatatest=SlipTable::where('number',$code_sl)->first();
                    if(empty($slipdatatest) || $slipdatatest==NULL)
                    {
                        $kondisi=true;
                    }
                    else
                    {
                        if($slipdata != null){
                            if($sliplastid < 9)
                            {
                                $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + $i);
                            }   
                            elseif($sliplastid > 8 && $sliplastid < 99)
                            {
                                $code_sl = "FE".  $mydate . "000" . strval($sliplastid + $i);
                            }
                            elseif($sliplastid > 98 && $sliplastid < 999)
                            {
                                $code_sl = "FE".  $mydate . "00" . strval($sliplastid + $i);
                            }
                            elseif($sliplastid > 998 && $sliplastid < 9999)
                            {
                                $code_sl = "FE".  $mydate . "0" . strval($sliplastid + $i);
                            }
                            elseif($sliplastid > 9998 && $sliplastid < 99999)
                            {
                                $code_sl = "FE".  $mydate . strval($sliplastid + $i);
                            }
                        }
                        else{
                            $code_sl = "FE".  $mydate . "0000" . strval(1);
                        }
                    }

                    $i++;
                }

        }
        else
        {
            $slip = SlipTable::orderby('id','asc')->get();
            $slip_now = SlipTable::whereDate('created_at',$currdate)->where('slip_type','fe')->orderby('id','asc')->get();
            $sliplastid = count($slip_now);

            if($sliplastid != null){
                if($sliplastid < 9)
                {
                    $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + 1);
                }   
                elseif($sliplastid > 8 && $sliplastid < 99)
                {
                    $code_sl = "FE".  $mydate . "000" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 98 && $sliplastid < 999)
                {
                    $code_sl = "FE".  $mydate . "00" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 998 && $sliplastid < 9999)
                {
                    $code_sl = "FE".  $mydate . "0" . strval($sliplastid + 1);
                }
                elseif($sliplastid > 9998 && $sliplastid < 99999)
                {
                    $code_sl = "FE".  $mydate . strval($sliplastid + 1);
                }
    
                
            }
            else{
                $code_sl = "FE".  $mydate . "0000" . strval(1);
            }


            $slipdata=SlipTable::orderBy('id', 'desc')->first();
        }

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();


        
        
        // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $locationlist = TransLocationTemp::where('insured_id','=',$code_ms)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();
        $attachmentlist = SlipTableFile::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->where('status','=','passive')->orderby('id','desc')->delete();

        // $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();


        // $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->where('insured_id','=',$code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();

        
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->where('slip_type','fe')->orderby('id','desc')->get();
         
        //dd($locationlist2);
        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                //$risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->where('count_endorsement',$insureddata->count_endorsement)->get();
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  


        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipupdate', compact(['user','userid','cnd','slipdata2','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }

    public function updatefeslipmodal(Request $request){

        $validator = $request->validate([
            'slipnumber'=>'required'
        ]);

        if($validator)
        {
            $user = Auth::user();
                
                $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
                
                 $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
                $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();


                $currdate = date("Y-m-d");

                $slipipfromdate = str_replace('/', '-', $request->slipipfrom);
                $slipiptodate = str_replace('/', '-', $request->slipipto);
                $sliprpfromdate = str_replace('/', '-', $request->sliprpfrom);
                $sliprptodate = str_replace('/', '-', $request->sliprpto);

                $slipdataid=$slipdata->number;
                $slipdatalatest = SlipTable::where('number',$slipdataid)->where('insured_id',$request->code_ms)->orderby('created_at','desc')->first();
                $slipdataup = SlipTable::where('number',$slipdataid)->orderby('created_at','desc')->first();

                if($slipdataup->status != $request->slipstatus){
                    StatusLog::create([
                        'status'=>$request->slipstatus,
                        'user'=>Auth::user()->name,
                        'datetime'=>date('Y-m-d H:i:s '),
                        'insured_id'=>$request->code_ms,
                        'slip_id'=>$request->slipnumber,
                        'slip_type'=>'fe',
                        'count_endorsement'=> $slipdatalatest->endorsment
                    ]);
                }

                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
                $slipdataup->slip_type= 'fe';
                $slipdataup->prod_year=$currdate;
                // $slipdataup->date_transfer=date("Y-m-d", strtotime($request->slipdatetransfer));
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment=$slipdatalatest->endorsment;
                $slipdataup->selisih="false";
                $slipdataup->source=$request->slipcedingbroker;
                $slipdataup->source_2=$request->slipceding;
                $slipdataup->cob=$request->slipcob;
                $slipdataup->koc=$request->slipkoc;
                $slipdataup->occupacy=$request->slipoccupacy;
                $slipdataup->build_const=$request->slipbld_const;
                $slipdataup->slip_no=$request->slipno; 
                $slipdataup->cn_dn=$request->slipcndn; 
                $slipdataup->policy_no=$request->slippolicy_no; 
                $slipdataup->attacment_file=''; 
                $slipdataup->interest_insured=$interestlist->toJSon();
                $slipdataup->total_sum_insured=$request->sliptotalsum; 
                $slipdataup->share_tsi=$request->sharetotalsum; 
                $slipdataup->type_tsi=$request->sliptypetsi; 
                $slipdataup->type_share_tsi=$request->sharetypetsi; 
                $slipdataup->total_day=$request->sliptotalday; 
                $slipdataup->total_year=$request->sliptotalyear; 
                $slipdataup->sum_total_date=$request->slipdatesum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->extend_coverage=$extendcoveragelist->toJson();  
                $slipdataup->insurance_period_from=date("Y-m-d", strtotime($slipipfromdate));  
                $slipdataup->insurance_period_to=date("Y-m-d", strtotime($slipiptodate));  
                $slipdataup->reinsurance_period_from=date("Y-m-d", strtotime($sliprpfromdate));  
                $slipdataup->reinsurance_period_to=date("Y-m-d", strtotime($sliprptodate));
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate;  
                $slipdataup->sliptotalrate=$request->slipsumrate;  
                $slipdataup->v_broker=$request->slipvbroker;
                $slipdataup->sum_feebroker=$request->slipsumvbroker;
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
                $slipdataup->wpc=$request->wpc;
                $slipdataup->remarks=$request->remarks;

                $slipdataup->save();


                $notification = array(
                    'message' => 'Fire & Engginering Slip Update successfully!',
                    'alert-type' => 'success'
                );

                //$insdata = Insured::where('number',$request->code_ms)->where('slip_type','fe')->first();
                $insdata = Insured::where('number',$request->code_ms)->first();

                $old_nasre_share = $insdata->share_from;
                $current_share = $request->slipshare;
                $new_nasre_share = floatval($old_nasre_share + $current_share);

    
                if($new_nasre_share != $old_nasre_share){
                    $msdata = Insured::findOrFail($insdata->id);
    
                    $msdata->share_from=$new_nasre_share;
                    $msdata->save();
                }

                    $deductibleup = DeductibleTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($deductibleup as $ddup)
                    {
                        $deductibleprocessup = DeductibleTemp::findOrFail($ddup->id);
                        $deductibleprocessup->status = 'active';
                        $deductibleprocessup->save();
                    }

                    $extendcoverageup = ExtendCoverageTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($extendcoverageup as $ecup)
                    {
                        $extendcoverageprocessup = ExtendCoverageTemp::findOrFail($ecup->id);
                        $extendcoverageprocessup->status = 'active';
                        $extendcoverageprocessup->save();
                    }

                    $installmentpansup = InstallmentTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($installmentpansup as $ipup)
                    {
                        $inspanprocessup = InstallmentTemp::findOrFail($ipup->id);
                        $inspanprocessup->status = 'active';
                        $inspanprocessup->save();
                    }

                    $retrocessionpanup = RetrocessionTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($retrocessionpanup as $rpup)
                    {
                        $retropanprocessup = RetrocessionTemp::findOrFail($rpup->id);
                        $retropanprocessup->status = 'active';
                        $retropanprocessup->save();
                    }


                return response()->json(
                    [
                        'id' => $slipdataup->id,
                        'slipstatus' => $slipdataup->status,
                        'new_share_nasre' => $msdata->share_from,
                        'ceding'=>$slipdataup->ceding->name,
                        'cedingbroker'=>$slipdataup->cedingbroker->name,
                        'count_endorsement'=>$slipdataup->endorsment
                    ]
                );
        }
        else
        {
            $notification = array(
                'message' => 'Fire & Engginering Slip added Failed!, missing data',
                'alert-type' => 'Failed'
            );

            return response($notification);
        }

    }


    public function endorsementfeslip($ms,$sl)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
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
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $code_ms=$ms;
        $code_sl=$sl;
        
        $insureddata=Insured::where('number',$code_ms)->first();
        $slipdata=SlipTable::where('insured_id',$code_ms)->first();
        $slipdata2=SlipTable::where('insured_id',$code_ms)->get();


        if($slipdata==NULL || empty($slipdata) || $code_ms==0 || $code_sl==0)
        {

            $insureddata=Insured::where('slip_type','fe')->orderby('id','desc')->first();
            $slipdata=SlipTable::where('insured_id',$insureddata->number)->orderby('id','desc')->first();
            
            $code_ms=$insureddata->number;
            $countendorsement =$slipdata->endorsment;
            if($slipdata->endorsment==NULL || $slipdata->endorsment=="")
            {
                $code_sl = $slipdata->number . '-END' . '000' . '1';
            }
            else 
            {
                if($countendorsement < 9)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 8 && $countendorsement < 99)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 98 && $countendorsement < 999)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 998 && $countendorsement < 9999)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . ($countendorsement + 1);
                }
            }

            if($slipdata->prev_endorsement==NULL || $slipdata->prev_endorsement=="")
            {
                $slipdata->prev_endorsement=$sl;
            }
        
        
        }
        else
        {

            $countendorsement =$slipdata->endorsment;
            if($slipdata->endorsment==NULL || $slipdata->endorsment=="")
            {
                $code_sl = $slipdata->number . '-END' . '000' . '1';
            }
            else 
            {
                if($countendorsement < 9)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '000' . ($countendorsement + 1);
                }
                elseif($countendorsement > 8 && $countendorsement < 99)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '00' . ($countendorsement + 1);
                }
                elseif($countendorsement > 98 && $countendorsement < 999)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . '0' . ($countendorsement + 1);
                }
                elseif($countendorsement > 998 && $countendorsement < 9999)
                {
                    $code_sl = substr($slipdata->number,0,15) . '-END' . ($countendorsement + 1);
                }
            }

            if($slipdata->prev_endorsement==NULL || $slipdata->prev_endorsement=="")
            {
                $slipdata->prev_endorsement=$sl;
            }

        }

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  


        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipendorsement', compact(['user','cnd','slipdata2','countendorsement','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }

    public function detailfeslip($idm)
    {
        $user = Auth::user();
        $country = User::orderby('id','asc')->get();
        $route_active = 'Fire Engineering - Slip Entry';
        $mydate = date("Y").date("m").date("d");
        $costumer=Customer::orderby('id','asc')->get();

        $currdate = date("d/m/Y");
        $insured = Insured::orderby('id','asc')->get();
        $slip = SlipTable::orderby('id','asc')->get();
        $currency = Currency::orderby('id','asc')->get();
        $cob = COB::orderby('id','asc')->get();
        $koc = Koc::where('parent_id',2)->orWhere('id',2)->orderby('id','asc')->get();
        $ocp = Occupation::orderby('id','asc')->get();
        $cedingbroker = CedingBroker::orderby('id','asc')->get();
        $ceding = CedingBroker::orderby('id','asc')->where('type','ceding')->get();
        $felookup = FelookupLocation::orderby('id','asc')->get();
        $cnd = ConditionNeeded::orderby('id','asc')->get();
        $deductibletype= DeductibleType::orderby('id','asc')->get();
        $extendedcoverage= ExtendedCoverage::orderby('id','asc')->get();

        $fe_ids = response()->json($insured->modelKeys());
        
        $insureddata=Insured::find($idm);
        // dd($insureddata->number);
        $code_ms=$insureddata->number;
        $slipdata=SlipTable::where('insured_id',$insureddata->number)->first();
        $slipdata2=SlipTable::where('insured_id',$insureddata->number)->get();
        // dd($slipdata);
        $code_sl=$slipdata->number;

        $interestinsured= InterestInsured::orderby('id','asc')->get();
        $interestlist= InterestInsuredTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        
        $filelist=SlipTableFile::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$code_sl)->orderby('id','desc')->get();       
        
        $locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
        $locationlist=[];

        if(!empty($locationlist2))
        {
            foreach($locationlist2 as $datadetail)
            {
                $risklocationdetaildata= RiskLocationDetail::where('translocation_id','=',$datadetail->id)->get();
                
                $riskdetaillist=[];

                foreach($risklocationdetaildata as $stt)
                {
                    
                    $interestdata=InterestInsured::where('id','=',$stt->interest_id)->first();
                    $cedingdata=CedingBroker::where('id','=',$stt->ceding_id)->first();

                    $stt->interestdetail=$interestdata;
                    $stt->cedingdetail=$cedingdata;

                    array_push($riskdetaillist,$stt);
                }


                $datadetail->risklocationdetail=$riskdetaillist;
           
                array_push($locationlist,$datadetail);
            }     
        }  



        $statuslist= StatusLog::where('insured_id','=',$code_sl)->orderby('id','desc')->get();
            

        return view('crm.transaction.fe_slipdetail', compact(['user','slipdata2','cnd','filelist','slipdata','insureddata','statuslist','retrocessionlist','installmentlist','extendcoveragelist','deductiblelist','extendedcoverage','extendedcoverage','deductibletype','interestinsured','locationlist','interestlist','felookup','currency','cob','koc','ocp','ceding','cedingbroker','route_active','currdate','slip','insured','fe_ids','code_ms','code_sl','costumer']));
    
    }


    public function getdetailSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('id',$idm)->first();
    

        
        if(!empty($slipdata->deductible_panel))
        {
            $deductibledata=json_decode($slipdata->deductible_panel);   
        }
        else
        {
            $deductibledata=null;
        }
        $newarraydeduct=[];
        // dd($deductibledata);
        if(!empty($deductibledata))
        {
            foreach($deductibledata as $mydata)
            {
                $deductdatadesc= DeductibleType::where('id','=',$mydata->deductibletype_id)->first();
                if($deductdatadesc){
                    $mydata->deductibletype=$deductdatadesc->description;
                }
               
                
                $currencydesc=Currency::where('id','=',$mydata->currency_id)->first();
                if($currencydesc){
                    $mydata->currencydata=$currencydesc->symbol_name;
                }
                array_push($newarraydeduct,$mydata);
            }     
        }  
        $newdeductdata=json_encode($newarraydeduct);



        if(!empty($slipdata->extend_coverage))
        {
            $extendcoverdata=json_decode($slipdata->extend_coverage);   
        }
        else
        {
            $extendcoverdata=null;
        }
        // $extendcoverdata=json_decode($slipdata->extend_coverage);   
        $newarrayextend=[];

        if(!empty($extendcoverdata))
        {
            foreach($extendcoverdata as $mydata)
            {
                $extenddesc= ExtendedCoverage::where('id','=',$mydata->extendcoverage_id)->first();
                if($extenddesc){
                    $mydata->coveragetype=$extenddesc->description;
                }
                
                array_push($newarrayextend,$mydata);
            }       
        }
        $newextenddata=json_encode($newarrayextend);


        if(!empty($slipdata->installment_panel))
        {
            $installmentpdata=json_decode($slipdata->installment_panel);   
        }
        else
        {
            $installmentpdata=null;
        }
        // $extendcoverdata=json_decode($slipdata->extend_coverage);   
        $newarrayinspan=[];

        if(!empty($installmentpdata))
        {
            foreach($installmentpdata as $ipdata)
            {
                // $ipddesc= ExtendedCoverage::where('id','=',$ipdata->extendcoverage_id)->first();
                // if($ipddesc){
                //     $ipdata->coveragetype=$ipddesc->description;
                // }
                
                array_push($newarrayinspan,$ipdata);
            }       
        }
        $newarrayinspandata=json_encode($newarrayinspan);


        $dateyeardata= date("d/m/Y", strtotime($slipdata->prod_year));


        $statuslist= StatusLog::where('slip_id',$slipdata->number)->where('insured_id',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->where('slip_type','fe')->orderby('created_at','DESC')->take(5)->get();
        
        // if(empty($slipdata->insured_id) || $slipdata->insured_id == NULL)
        // {
        //     $attachmentlist= SlipTableFile::where('slip_id','=',$slipdata->number)->orderby('id','DESC')->get();
            
        // }
        // else
        // {
        //     //$attachmentlist= SlipTableFile::where('slip_id','=',$slipdata->number)->orderby('id','DESC')->get();
            
        // $attachmentlist= SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','fe')->where('count_endorsement',$slipdata->endorsment)->orderby('id','DESC')->get();
        // $attachmentlist = DB::table('slip_table_file')
        //             ->where('slip_id','=',$slipdata->number)
        //             ->where('insured_id','=',$slipdata->insured_id)
        //             ->where('slip_type','fe')
        //             ->where('count_endorsement',$slipdata->endorsment)        
        //             ->orderby('id','desc')
        //             ->distinct('slip_table_file.filename')
        //             ->get();
        $attachmenttable = collect(SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','fe')->where('count_endorsement',$slipdata->endorsment)->orderby('id','DESC')->get());
        $attachmentlist = $attachmenttable->unique('filename');
        $attachmentlist->values()->all();
        // }

        $sum_permilec = DB::table('extended_coverage_detail')
                            ->where('slip_id',$slipdata->number)
                            ->where('insured_id','=',$slipdata->insured_id)
                            ->where('slip_type','fe')
                            ->where('count_endorsement',$slipdata->endorsment)
                            ->sum('extended_coverage_detail.percentage');

        $sum_inspanpercent = DB::table('installment_panel_detail')
                            ->where('slip_id',$slipdata->number)
                            ->where('insured_id','=',$slipdata->insured_id)
                            ->where('slip_type','fe')
                            ->where('count_endorsement',$slipdata->endorsment)
                            ->sum('installment_panel_detail.percentage');


        if($slipdata->build_const == "Building 1"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_1;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_1;

        }elseif($slipdata->build_const == "Building 2"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_2;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_2;
        }elseif($slipdata->build_const == "Building 3"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_3;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_3;
        }
      

        return response()->json(
            [
                'id' => $slipdata->id,
                'insured_id' => $slipdata->insured_id,
                'slip_type' => $slipdata->slip_type,
                'username' => $slipdata->username,
                'prod_year' => $dateyeardata,
                'number' => $slipdata->number,
                'slipuy' => $slipdata->uy,
                'date_transfer' => date("d/m/Y", strtotime($slipdata->date_transfer)),
                'status' => $slipdata->status,
                'endorsment' => $slipdata->endorsment,
                'selisih' => $slipdata->selisih,
                'source' => $slipdata->source,
                'source_2' => $slipdata->source_2,
                'currency'=> $slipdata->currency,
                'cob'=> $slipdata->cob,
                'koc'=> $slipdata->koc,
                'occupacy'=> $slipdata->occupacy,
                'build_const'=> $slipdata->build_const,
                'build_rate_up'=> $building_rate_up,
                'build_rate_down'=> $building_rate_down,
                'slip_no'=> $slipdata->slip_no,
                'cn_dn'=> $slipdata->cn_dn,
                'policy_no'=> $slipdata->policy_no,
                'attacment_file'=> $attachmentlist,
                'type_tsi'=> $slipdata->type_tsi,
                'total_sum_insured'=> $slipdata->total_sum_insured,
                'type_share_tsi'=> $slipdata->type_share_tsi,
                'share_tsi'=> $slipdata->share_tsi,
                'insured_type'=>$slipdata->insured_type,
                'insured_pct'=>$slipdata->insured_pct,
                'total_sum_pct'=>$slipdata->total_sum_pct,
                'deductible_panel'=>$newdeductdata,
                'extend_coverage'=>$newextenddata,
                'insurance_period_from'=>date("d/m/Y", strtotime($slipdata->insurance_period_from)),
                'insurance_period_to'=>date("d/m/Y", strtotime($slipdata->insurance_period_to)),
                'reinsurance_period_from'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_from)),
                'reinsurance_period_to'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_to)),
                'proportional'=>$slipdata->proportional,
                'layer_non_proportional'=>$slipdata->layer_non_proportional,
                'rate'=>$slipdata->rate,
                'sum_rate'=>$slipdata->sliptotalrate,
                'share'=>$slipdata->share,
                'sum_share'=>$slipdata->sum_share,
                'basic_premium'=>$slipdata->basic_premium,
                'commission'=>$slipdata->commission,
                'grossprm_to_nr'=>$slipdata->grossprm_to_nr,
                'netprm_to_nr'=>$slipdata->netprm_to_nr,
                'installment_panel'=>$slipdata->installment_panel,
                'sum_commission'=>$slipdata->sum_commission,
                'retro_backup'=>$slipdata->retro_backup,
                'own_retention'=>$slipdata->own_retention,
                'sum_own_retention'=>$slipdata->sum_own_retention,
                'retrocession_panel'=>$slipdata->retrocession_panel,
                'endorsment'=>$slipdata->endorsment,
                'prev_endorsement'=>$slipdata->prev_endorsement,
                'condition_needed'=>$slipdata->condition_needed,
                'created_at'=>$slipdata->created_at,
                'updated_at'=>$slipdata->updated_at,
                'wpc'=>$slipdata->wpc,
                'remarks'=>$slipdata->remarks,
                'v_broker'=>$slipdata->v_broker,
                'sum_v_broker'=>$slipdata->sum_feebroker,
                'total_day'=>$slipdata->total_day,
                'total_year'=>$slipdata->total_year,
                'sum_total_date'=>$slipdata->sum_total_date,
                'coinsurance_slip'=>$slipdata->coinsurance_slip,
                'status_log'=>$statuslist,
                'sum_feebroker'=>$slipdata->sum_feebroker,
                'sum_ec'=>$sum_permilec,
                'sum_ippercent' =>$sum_inspanpercent
            ]
        );

    }

    public function getdetailEndorsementSlip($idm)
    {
        $user = Auth::user();
        $slipdata=SlipTable::where('id',$idm)->first();

        $countendorsement=$slipdata->endorsment;

        if($slipdata->endorsment==NULL || $slipdata->endorsment=="")
        {
            $code_sl = $slipdata->number . '000' . '1';
        }
        else 
        {
            if($countendorsement < 9)
            {
                $code_sl = substr($slipdata->number,0,15) . '000' . ($countendorsement + 1);
            }
            elseif($countendorsement > 8 && $countendorsement < 99)
            {
                $code_sl = substr($slipdata->number,0,15) .  '00' . ($countendorsement + 1);
            }
            elseif($countendorsement > 98 && $countendorsement < 999)
            {
                $code_sl = substr($slipdata->number,0,15) . '0' . ($countendorsement + 1);
            }
            elseif($countendorsement > 998 && $countendorsement < 9999)
            {
                $code_sl = substr($slipdata->number,0,15) . ($countendorsement + 1);
            }
        }


        // $interestdata=json_decode($slipdata->interest_insured);   
        // $newarray=[];

        // if(!empty($interestdata))
        // {
        //     foreach($interestdata as $mydata)
        //     {
        //         $interestdatadesc= InterestInsured::where('id','=',$mydata->interest_id)->first();
        //         $mydata->description=$interestdatadesc->description;     
                
        //         array_push($newarray,$mydata);
        //     }  
        // }     

        // $newinterestdata=json_encode($newarray);


        $deductibledata=json_decode($slipdata->deductible_panel);  
        $newarraydeduct=[];
        if(!empty($deductibledata))
        {
            foreach($deductibledata as $mydata)
            {
                $deductdatadesc= DeductibleType::where('id','=',$mydata->deductibletype_id)->first();
                $mydata->deductibletype=$deductdatadesc->description;
                
                $currencydesc=Currency::where('id','=',$mydata->currency_id)->first();
                $mydata->currencydata=@$currencydesc->symbol_name;
                
                array_push($newarraydeduct,$mydata);
            }     
        }  
        $newdeductdata=json_encode($newarraydeduct);


        $extendcoverdata=json_decode($slipdata->extend_coverage);
        $newarrayextend=[];
        if(!empty($extendcoverdata))
        {
            foreach($extendcoverdata as $mydata)
            {
                $extenddesc= ExtendedCoverage::where('id','=',$mydata->extendcoverage_id)->first();
                $mydata->coveragetype=$extenddesc->description;
                
                array_push($newarrayextend,$mydata);
            }       
        }
        $newextenddata=json_encode($newarrayextend);


        $dateyeardata=  date("d/m/Y", strtotime($slipdata->prod_year));


        if(!empty($slipdata->installment_panel))
        {
            $installmentpdata=json_decode($slipdata->installment_panel);   
        }
        else
        {
            $installmentpdata=null;
        }
        // $extendcoverdata=json_decode($slipdata->extend_coverage);   
        $newarrayinspan=[];

        if(!empty($installmentpdata))
        {
            foreach($installmentpdata as $ipdata)
            {
                // $ipddesc= ExtendedCoverage::where('id','=',$ipdata->extendcoverage_id)->first();
                // if($ipddesc){
                //     $ipdata->coveragetype=$ipddesc->description;
                // }
                
                array_push($newarrayinspan,$ipdata);
            }       
        }
        $newarrayinspandata=json_encode($newarrayinspan);


        $statuslist= StatusLog::where('slip_id',$slipdata->number)->where('insured_id',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->where('slip_type','fe')->orderby('created_at','DESC')->take(5)->get();
        
        
        $attachmenttable = collect(SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','fe')->where('count_endorsement',$slipdata->endorsment)->orderby('id','DESC')->get());
        $attachmentlist = $attachmenttable->unique('filename');
        $attachmentlist->values()->all();


        $sum_permilec = DB::table('extended_coverage_detail')
                            ->where('slip_id',$slipdata->number)
                            ->where('insured_id','=',$slipdata->insured_id)
                            ->where('slip_type','fe')
                            ->where('count_endorsement',$slipdata->endorsment)
                            ->sum('extended_coverage_detail.percentage');

        $sum_inspanpercent = DB::table('installment_panel_detail')
                            ->where('slip_id',$slipdata->number)
                            ->where('insured_id','=',$slipdata->insured_id)
                            ->where('slip_type','fe')
                            ->where('count_endorsement',$slipdata->endorsment)
                            ->sum('installment_panel_detail.percentage');



        if($slipdata->build_const == "Building 1"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_1;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_1;

        }elseif($slipdata->build_const == "Building 2"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_2;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_2;
        }elseif($slipdata->build_const == "Building 3"){
            $building_rate = Occupation::where('id',$slipdata->occupacy)->first(); 
            $building_rate_up = $building_rate->rate_batas_atas_building_class_3;
            $building_rate_down = $building_rate->rate_batas_bawah_building_class_3;
        }

        

    
        return response()->json(
            [
                'id' => $slipdata->id,
                'code_slreal'=>$slipdata->number,
                'code_sl'=>$code_sl,
                'insured_id' => $slipdata->insured_id,
                'slip_type' => $slipdata->slip_type,
                'username' => $slipdata->username,
                'prod_year' => $dateyeardata,
                'number' => $slipdata->number,
                'slipuy' => $slipdata->uy,
                'date_transfer' => date("d/m/Y", strtotime($slipdata->date_transfer)),
                'status' => $slipdata->status,
                'endorsment' => $slipdata->endorsment,
                'selisih' => $slipdata->selisih,
                'source' => $slipdata->source,
                'source_2' => $slipdata->source_2,
                'currency'=> $slipdata->currency,
                'cob'=> $slipdata->cob,
                'koc'=> $slipdata->koc,
                'occupacy'=> $slipdata->occupacy,
                'build_const'=> $slipdata->build_const,
                'build_rate_up'=> $building_rate_up,
                'build_rate_down'=> $building_rate_down,
                'slip_no'=> $slipdata->slip_no,
                'cn_dn'=> $slipdata->cn_dn,
                'policy_no'=> $slipdata->policy_no,
                'attacment_file'=> $attachmentlist,
                'total_sum_insured'=> $slipdata->total_sum_insured,
                'insured_type'=>$slipdata->insured_type,
                'insured_pct'=>$slipdata->insured_pct,
                'total_sum_pct'=>$slipdata->total_sum_pct,
                'deductible_panel'=>$newdeductdata,
                'extend_coverage'=>$newextenddata,
                'insurance_period_from'=>date("d/m/Y", strtotime($slipdata->insurance_period_from)),
                'insurance_period_to'=>date("d/m/Y", strtotime($slipdata->insurance_period_to)),
                'reinsurance_period_from'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_from)),
                'reinsurance_period_to'=>date("d/m/Y", strtotime($slipdata->reinsurance_period_to)),
                'proportional'=>$slipdata->proportional,
                'layer_non_proportional'=>$slipdata->layer_non_proportional,
                'rate'=>$slipdata->rate,
                'share'=>$slipdata->share,
                'sum_share'=>$slipdata->sum_share,
                'basic_premium'=>$slipdata->basic_premium,
                'commission'=>$slipdata->commission,
                'grossprm_to_nr'=>$slipdata->grossprm_to_nr,
                'netprm_to_nr'=>$slipdata->netprm_to_nr,
                'installment_panel'=>$newarrayinspandata,
                'sum_commission'=>$slipdata->sum_commission,
                'retro_backup'=>$slipdata->retro_backup,
                'own_retention'=>$slipdata->own_retention,
                'sum_own_retention'=>$slipdata->sum_own_retention,
                'retrocession_panel'=>$slipdata->retrocession_panel,
                'endorsment'=>$slipdata->endorsment,
                'prev_endorsement'=>$slipdata->prev_endorsement,
                'condition_needed'=>$slipdata->condition_needed,
                'created_at'=>$slipdata->created_at,
                'updated_at'=>$slipdata->updated_at,
                'wpc'=>$slipdata->wpc,
                'remarks'=>$slipdata->remarks,
                'v_broker'=>$slipdata->v_broker,
                'coinsurance_slip'=>$slipdata->coinsurance_slip,
                'status_log'=>$statuslist,
                'sum_feebroker'=>$slipdata->sum_feebroker,
                'sum_ec'=>$sum_permilec,
                'sum_ippercent' =>$sum_inspanpercent
            ]
        );

    }


    public function storefeinsured(Request $request)
    {   
        
        $validator = $request->validate([
            'fessuggestinsured'=>'required'
        ]);
        
        $costumcheck=Customer::where('company_name','=',$request->fessuggestinsured)->first();
        if($costumcheck==null)
        {

            Customer::create([
                'owner_id'=>'1',
                'industry_id'=>'27',
                'company_prefix' => $request->fesinsured,
                'company_name'=>$request->fessuggestinsured,
                'website'=>$request->fessuggestinsured,
                'company_suffix'=>$request->fessuffix
            ]);

        }

        if($validator)
        {
            $user = Auth::user();
            
            $insureddata= Insured::where('number','=',$request->fesnumber)->first();
            $locationlist= TransLocationTemp::where('insured_id','=',$request->fesnumber)->where('slip_type','fe')->orderby('id','desc')->get();

            $sum_amount = DB::table('risk_location_detail')
                            ->join('trans_location_detail','trans_location_detail.id','=','risk_location_detail.translocation_id')
                            ->where('trans_location_detail.insured_id',$request->fesnumber)
                            ->sum('risk_location_detail.amountlocation');
            
            if($insureddata==null)
            {
                $insureddataup = Insured::create([
                    'number'=>$request->fesnumber,
                    'slip_type'=>'fe',

                    'insured_prefix' => strtoupper($request->fesinsured),
                    'insured_name'=> strtoupper($request->fessuggestinsured),
                    'insured_suffix'=> strtoupper($request->fessuffix),

                    'share'=>$sum_amount,
                    'share_from'=>$request->fessharefrom,
                    'statmodified'=>1,
                    'share_to'=>$request->fesshareto,
                    'coincurance'=>$request->fescoincurance,
                    'location'=>$locationlist->toJson(),
                    'uy'=>$request->feuy,
                    'count_endorsement'=>0,
                    'currency_id'=>$request->fecurrency
                    
                ]);

                $insurednumberdata = InsuredNumber::where('number',$request->fesnumber)->orderby('id','desc')->first();
                $insurednumberdata->status='active';
                $insurednumberdata->save();


                $notification = array(
                    'message' => 'Fire & Engginering Insured added successfully!',
                    'alert-type' => 'success',
                    'count_endorsement' => $insureddataup->count_endorsement,
                    'ceding_share' => $sum_amount
                );


            }
            else
            {
                $insureddataid=$insureddata->id;
                $insureddataup = Insured::findOrFail($insureddataid);

                $insureddataup->insured_prefix= strtoupper($request->fesinsured);
                $insureddataup->insured_name= strtoupper($request->fessuggestinsured);
                $insureddataup->insured_suffix= strtoupper($request->fessuffix);

                $insureddataup->share=$sum_amount;
                $insureddataup->statmodified=1;
                $insureddataup->share_from=$request->fessharefrom;
                $insureddataup->share_to=$request->fesshareto;
                $insureddataup->coincurance=$request->fescoincurance;
                $insureddataup->location=$locationlist->toJson();
                $insureddataup->uy=$request->feuy;
                $insureddataup->currency_id=$request->fecurrency;
                $insureddataup->save();

                $insurednumberdata = InsuredNumber::where('number',$request->fesnumber)->orderby('id','desc')->first();
                $insurednumberdata->status = 'active';


                $notification = array(
                    'message' => 'Fire & Engginering Insured Update successfully!',
                    'alert-type' => 'success',
                    'count_endorsement' => $insureddataup->count_endorsement,
                    'ceding_share' => $sum_amount
                );
            }

           

            return response($notification);
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


    public function storeMultiFile(Request $request)
    {
         
       $validatedData = $request->validate([
        // 'files' => 'required'
        ]);
 
        if($request->TotalFiles > 0)
        { 
                for ($x = 0; $x < $request->TotalFiles; $x++) 
                {
        
                    if ($request->hasFile('files'.$x)) 
                        {
                            $file = $request->file('files'.$x);
        
                            $path = 'public/files';
                            //$file->move(base_path('\public\files'), $file->getClientOriginalName());
                            //$name = $file->getClientOriginalName();

                            $extension = $file->getClientOriginalExtension(); 
                            
                            if($extension=="csv" || $extension=="txt" || $extension=="xlx" || $extension=="xls" || $extension=="pdf" || $extension=="ppt" || $extension=="pptx" || $extension=="doc" || $extension=="docx" || $extension=="jpg" || $extension=="jpeg" || $extension=="png")
                            {  
                                $name =  time() . rand(11111,99999).''.$file->getClientOriginalName();
                                $file->move(base_path('\public\files'),$name);
                                
                                $insert[$x]['filename'] = $name;
                                $insert[$x]['path'] = $path;
                                $insert[$x]['user_id'] = Auth::user()->name;
                                $insert[$x]['slip_id'] = $request->slip_id;
                                $insert[$x]['insured_id'] = $request->code_ms;
                                $insert[$x]['slip_type'] = $request->slip_type;
                                SlipTableFile::insert($insert);
                            }
                            else{
                                return response()->json(['message'=>'file type incorrect']);
                            }
                        }
                }
        
               
    
           return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
 
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }
 
    }


    public function storefeslip(Request $request)
    {
        $validator = $request->validate([
            'slipnumber'=>'required'
        ]);

        
        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('number','=',$request->slipnumber)->first();
            
            $interestlist= InterestInsuredTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','=','fe')->orderby('id','desc')->get();
        
            if($slipdata==null)
            {
                $currdate = date("Y-m-d");

                $slipdataup=SlipTable::create([
                    'number'=>$request->slipnumber,
                    'username'=>Auth::user()->name,
                    'insured_id'=>$request->code_ms,
                    'slip_type'=>'fe',
                    'prod_year' => $currdate,
                    // 'date_transfer'=> date("Y-m-d", strtotime($request->slipdatetransfer)),
                    'status'=>$request->slipstatus,
                    'endorsment'=>0,
                    'selisih'=>'false',
                    'source'=>$request->slipcedingbroker,
                    'source_2'=>$request->slipceding,
                    // 'currency'=>$request->slipcurrency,
                    'cob'=>$request->slipcob,
                    'koc'=>$request->slipkoc,
                    'occupacy'=>$request->slipoccupacy,
                    'build_const'=>$request->slipbld_const,
                    'slip_no'=>$request->slipno,
                    'cn_dn'=>$request->slipcndn,
                    'policy_no'=>$request->slippolicy_no,
                    //'attacment_file'=>json_encode($attachmentlist),
                    'attacment_file'=>'',
                    'interest_insured'=>$interestlist->toJSon(),
                    'total_sum_insured'=>$request->sliptotalsum,
                    'share_tsi'=>$request->slipsharetotalsum,
                    'type_tsi'=>$request->sliptypetotalsum,
                    'type_share_tsi'=>$request->sliptypetsishare,
                    'total_day'=>$request->sliptotalday,
                    'total_year'=>$request->sliptotalyear,
                    'sum_total_date'=>$request->slipdatesum,
                    'insured_type'=>$request->sliptype,
                    'insured_pct'=>$request->slippct,
                    'total_sum_pct'=>$request->sliptotalsumpct,
                    'deductible_panel'=>$deductiblelist->toJson(),
                    'extend_coverage'=>$extendcoveragelist->toJson(),
                    'insurance_period_from'=>date("Y-m-d", strtotime($request->slipipfrom)),
                    'insurance_period_to'=>date("Y-m-d", strtotime($request->slipipto)),
                    'reinsurance_period_from'=>date("Y-m-d", strtotime($request->sliprpfrom)),
                    'reinsurance_period_to'=>date("Y-m-d", strtotime($request->sliprpto)),
                    'proportional'=>$request->slipproportional,
                    'layer_non_proportional'=>$request->sliplayerproportional,
                    'rate'=>$request->sliprate,
                    'sliptotalrate'=>$request->sliptotalrate,
                    'v_broker'=>$request->slipvbroker,
                    'sum_feebroker'=>$request->slipsumvbroker,
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
                    'sum_own_retention'=>$request->slipsumor,
                    'wpc'=>$request->wpc,
                    'remarks'=>$request->remarks

                ]);

                $notification = array(
                    'message' => 'Fire & Engginering Slip added successfully!',
                    'alert-type' => 'success'
                );

                StatusLog::create([
                        'status'=>$request->slipstatus,
                        'user'=>Auth::user()->name,
                        'datetime'=>date('Y-m-d H:i:s '),
                        'insured_id'=>$request->code_ms,
                        'slip_id'=>$request->slipnumber,
                        'slip_type'=>'fe',
                        'count_endorsement'=> $slipdataup->endorsment
                    ]);

                

                
                //$insdata = Insured::where('number',$request->code_ms)->where('slip_type','fe')->first();
                $insdata = Insured::where('number',$request->code_ms)->first();
                // $old_sumshare = $request->slipoldsumshare;
    
                $old_nasre_share = $insdata->share_from;
                $new_nasre_share = $request->insured_share;

    
                if($new_nasre_share != $new_nasre_share){
                    $msdata = Insured::findOrFail($insdata->id);
    
                    $msdata->share_from=$new_nasre_share;
                    $msdata->save();
                }

                $slipnumberdata = SlipNumber::where('number',$request->slipnumber)->where('slip_type','fe')->orderby('id','desc')->first();
                $slipnumberdata->status = 'active';
                $slipnumberdata->save();


                $currdate2 = date("Y-m-d");
                $mydate = date("Y").date("m").date("d");
                $slip_now = SlipTable::whereDate('created_at',$currdate2)->where('slip_type','fe')->where('insured_id',$request->code_ms)->orderby('id','asc')->get();
                $sliplastid = count($slip_now);
                // dd($sliplastid);

                if($sliplastid != null)
                {
                    if($sliplastid < 9)
                    {
                        $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + 1);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 99)
                    {
                        $code_sl = "FE".  $mydate . "000" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 98 && $sliplastid < 999)
                    {
                        $code_sl = "FE".  $mydate . "00" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 998 && $sliplastid < 9999)
                    {
                        $code_sl = "FE".  $mydate . "0" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 9998 && $sliplastid < 99999)
                    {
                        $code_sl = "FE".  $mydate . strval($sliplastid + 1);
                    }

                    
                }
                else
                {
                    $code_sl = "FE".  $mydate . "0000" . strval(1);
                }

                $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number'=>$request->code_ms     
                    ]);

                    $deductibleup = DeductibleTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($deductibleup as $ddup)
                    {
                        $deductibleprocessup = DeductibleTemp::findOrFail($ddup->id);
                        $deductibleprocessup->status = 'active';
                        $deductibleprocessup->save();
                    }

                    $extendcoverageup = ExtendCoverageTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($extendcoverageup as $ecup)
                    {
                        $extendcoverageprocessup = ExtendCoverageTemp::findOrFail($ecup->id);
                        $extendcoverageprocessup->status = 'active';
                        $extendcoverageprocessup->save();
                    }

                    $installmentpansup = InstallmentTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($installmentpansup as $ipup)
                    {
                        $inspanprocessup = InstallmentTemp::findOrFail($ipup->id);
                        $inspanprocessup->status = 'active';
                        $inspanprocessup->save();
                    }

                    $retrocessionpanup = RetrocessionTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($retrocessionpanup as $rpup)
                    {
                        $retropanprocessup = RetrocessionTemp::findOrFail($rpup->id);
                        $retropanprocessup->status = 'active';
                        $retropanprocessup->save();
                    }

                return response()->json(
                    [
                        'id' => $slipdataup->id,
                        'number' => $request->slipnumber,
                        'slipnumber' => $code_sl,
                        'slipstatus' => $slipdataup->status,
                        'ceding'=>$slipdataup->ceding->name,
                        'cedingbroker'=>$slipdataup->cedingbroker->name,
                        'count_endorsement'=>$slipdataup->endorsment
                    ]
                );

                // $old_number = $request->slipnumber;
                // $newnumber = substr($old_number, 10,15);
                // $codenumber = substr($old_number, 0,10);

                // if(intval($newnumber) < 9)
                // {


                //     $count = substr($newnumber,14);
                //     $new_number = $codenumber . "0000" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }   
                // elseif(intval($newnumber) > 8 && intval($newnumber) < 99)
                // {
                //     $count = substr($newnumber,13);
                //     $new_number = $codenumber . "000" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 98 && intval($newnumber) < 999)
                // {
                //     $count = substr($newnumber,12);
                //     $new_number = $codenumber . "00" . strval(intval($count) + 1);


                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 998 && intval($newnumber) < 9999)
                // {
                //     $count = substr($newnumber,11);
                //     $new_number = $codenumber . "0" . strval(intval($count) + 1);


                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 9998 && intval($newnumber) < 99999)
                // {
                //     $count = substr($newnumber,10);
                //     $new_number = $codenumber  . strval(intval($count) + 1);

                

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                
            }
            else
            {
                
                $currdate = date("Y-m-d");

                $slipdataid=$slipdata->number;
                $slipdataup = SlipTable::where('number',$slipdataid)->orderby('created_at','desc')->first();

                if($slipdataup->status != $request->slipstatus){
                    StatusLog::create([
                        'status'=>$request->slipstatus,
                        'user'=>Auth::user()->name,
                        'datetime'=>date('Y-m-d H:i:s '),
                        'insured_id'=>$request->code_ms,
                        'slip_id'=>$request->slipnumber,
                        'slip_type'=>'fe',
                        'count_endorsement'=> $slipdataup->endorsment
                    ]);
                }

                $slipdataup->number=$request->slipnumber;
                $slipdataup->username=Auth::user()->name;
                $slipdataup->insured_id=$request->code_ms;
                $slipdataup->slip_type= 'fe';
                $slipdataup->prod_year=$currdate;
                // $slipdataup->date_transfer=date("Y-m-d", strtotime($request->slipdatetransfer));
                $slipdataup->status=$request->slipstatus;
                $slipdataup->endorsment=0;
                $slipdataup->selisih="false";
                $slipdataup->source=$request->slipcedingbroker;
                $slipdataup->source_2=$request->slipceding;
                // $slipdataup->currency=$request->slipcurrency;
                $slipdataup->cob=$request->slipcob;
                $slipdataup->koc=$request->slipkoc;
                $slipdataup->occupacy=$request->slipoccupacy;
                $slipdataup->build_const=$request->slipbld_const;
                $slipdataup->slip_no=$request->slipno; 
                $slipdataup->cn_dn=$request->slipcndn; 
                $slipdataup->policy_no=$request->slippolicy_no; 
                $slipdataup->attacment_file=''; 
                $slipdataup->interest_insured=$interestlist->toJSon();
                $slipdataup->total_sum_insured=$request->sliptotalsum; 
                $slipdataup->share_tsi=$request->slipsharetotalsum; 
                $slipdataup->type_tsi=$request->sliptypetotalsum; 
                $slipdataup->type_share_tsi=$request->sliptypetsishare; 
                $slipdataup->total_day=$request->sliptotalday; 
                $slipdataup->total_year=$request->sliptotalyear; 
                $slipdataup->sum_total_date=$request->slipdatesum; 
                $slipdataup->insured_type=$request->sliptype; 
                $slipdataup->insured_pct=$request->slippct; 
                $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
                $slipdataup->deductible_panel=$deductiblelist->toJson(); 
                $slipdataup->extend_coverage=$extendcoveragelist->toJson();  
                $slipdataup->insurance_period_from=date("Y-m-d", strtotime($request->slipipfrom));  
                $slipdataup->insurance_period_to=date("Y-m-d", strtotime($request->slipipto));  
                $slipdataup->reinsurance_period_from=date("Y-m-d", strtotime($request->sliprpfrom));  
                $slipdataup->reinsurance_period_to=date("Y-m-d", strtotime($request->sliprpto));
                $slipdataup->proportional=$request->slipproportional;
                $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
                $slipdataup->rate=$request->sliprate;
                $slipdataup->sliptotalrate=$request->sliptotalrate;  
                $slipdataup->v_broker=$request->slipvbroker;
                $slipdataup->sum_feebroker=$request->slipsumvbroker;
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
                $slipdataup->wpc=$request->wpc;
                $slipdataup->remarks=$request->remarks;

                $slipdataup->save();


                $notification = array(
                    'message' => 'Fire & Engginering Slip Update successfully!',
                    'alert-type' => 'success'
                );

                //$insdata = Insured::where('number',$request->code_ms)->where('slip_type','fe')->first();
                $insdata = Insured::where('number',$request->code_ms)->first();

                $old_nasre_share = $insdata->share_from;
                $new_nasre_share = $request->insured_share;

    
                if($new_nasre_share != $old_nasre_share){
                    $msdata = Insured::findOrFail($insdata->id);
    
                    $msdata->share_from=$new_nasre_share;
                    $msdata->save();
                }

                $slipnumberdata = SlipNumber::where('number',$request->slipnumber)->where('slip_type','fe')->orderby('id','desc')->first();
                $slipnumberdata->status = 'active';
                $slipnumberdata->save();

                $currdate2 = date("Y-m-d");
                $mydate = date("Y").date("m").date("d");
                $slip_now = SlipTable::whereDate('created_at',$currdate2)->where('slip_type','fe')->where('insured_id',$request->code_ms)->orderby('id','asc')->get();
                $sliplastid = count($slip_now);
                // dd($sliplastid);

                if($sliplastid != null)
                {
                    if($sliplastid < 9)
                    {
                        $code_sl = "FE".  $mydate . "0000" . strval($sliplastid + 1);
                    }   
                    elseif($sliplastid > 8 && $sliplastid < 99)
                    {
                        $code_sl = "FE".  $mydate . "000" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 98 && $sliplastid < 999)
                    {
                        $code_sl = "FE".  $mydate . "00" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 998 && $sliplastid < 9999)
                    {
                        $code_sl = "FE".  $mydate . "0" . strval($sliplastid + 1);
                    }
                    elseif($sliplastid > 9998 && $sliplastid < 99999)
                    {
                        $code_sl = "FE".  $mydate . strval($sliplastid + 1);
                    }

                    
                }
                else
                {
                    $code_sl = "FE".  $mydate . "0000" . strval(1);
                }

                $reservedslipnumber = SlipNumber::create([
                            'number'=>$code_sl,
                            'slip_type'=>'fe',
                            'status'=>'passive',
                            'insured_number' => $request->code_ms     
                    ]);

                $deductibleup = DeductibleTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($deductibleup as $ddup)
                    {
                        $deductibleprocessup = DeductibleTemp::findOrFail($ddup->id);
                        $deductibleprocessup->status = 'active';
                        $deductibleprocessup->save();
                    }

                    $extendcoverageup = ExtendCoverageTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($extendcoverageup as $ecup)
                    {
                        $extendcoverageprocessup = ExtendCoverageTemp::findOrFail($ecup->id);
                        $extendcoverageprocessup->status = 'active';
                        $extendcoverageprocessup->save();
                    }

                    $installmentpansup = InstallmentTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($installmentpansup as $ipup)
                    {
                        $inspanprocessup = InstallmentTemp::findOrFail($ipup->id);
                        $inspanprocessup->status = 'active';
                        $inspanprocessup->save();
                    }

                    $retrocessionpanup = RetrocessionTemp::where('slip_id',$request->slipnumber)->where('insured_id','=',$request->code_ms)->where('slip_type','fe')->where('status','passive')->orderby('id','desc')->get();
                    foreach($retrocessionpanup as $rpup)
                    {
                        $retropanprocessup = RetrocessionTemp::findOrFail($rpup->id);
                        $retropanprocessup->status = 'active';
                        $retropanprocessup->save();
                    }

                return response()->json(
                    [
                        'id' => $slipdataup->id,
                        'number' => $request->slipnumber,
                        'slipnumber' => $code_sl,
                        'slipstatus' => $slipdataup->status,
                        'ceding'=>$slipdataup->ceding->name,
                        'cedingbroker'=>$slipdataup->cedingbroker->name,
                        'count_endorsement'=>$slipdataup->endorsment
                    ]
                );

                // $old_number = $request->slipnumber;
                // $newnumber = substr($old_number, 10,15);
                // $codenumber = substr($old_number, 0,10);

                // if(intval($newnumber) < 9)
                // {
                //     $count = substr($newnumber,14);
                //     $new_number = $codenumber . "0000" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }   
                // elseif(intval($newnumber) > 8 && intval($newnumber) < 99)
                // {
                //     $count = substr($newnumber,13);
                //     $new_number = $codenumber . "000" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 98 && intval($newnumber) < 999)
                // {
                //     $count = substr($newnumber,12);
                //     $new_number = $codenumber . "00" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 998 && intval($newnumber) < 9999)
                // {
                //     $count = substr($newnumber,11);
                //     $new_number = $codenumber . "0" . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }
                // elseif(intval($newnumber) > 9998 && intval($newnumber) < 99999)
                // {
                //     $count = substr($newnumber,10);
                //     $new_number = $codenumber  . strval(intval($count) + 1);

                //     $reservedslipnumber = SlipNumber::create([
                //             'number'=>$new_number,
                //             'slip_type'=>'fe',
                //             'status'=>'passive'     
                //     ]);

                //     return response()->json(
                //         [
                //             'id' => $slipdataup->id,
                //             'number' => $request->slipnumber,
                //             'slipnumber' => $new_number,
                //             'slipstatus' => $slipdataup->status,
                //             'ceding'=>$slipdataup->ceding->name,
                //             'cedingbroker'=>$slipdataup->cedingbroker->name,
                //             'count_endorsement'=>$slipdataup->endorsment
                //         ]
                //     );
                // }

                

                
                // $kondisi=0;
                // $im=1;
                // while($kondisi==0)
                // {
                //     $checkdataslip= SlipTable::where('number',$new_number)->first();

                //    if(!empty($checkdataslip))
                //     {
                //         $newnumber2 = substr($new_number, 10,15);
                //         $codenumber = substr($new_number, 0,10);

                //         if(intval($newnumber2) < 9)
                //         {
                //             $count = substr($newnumber2,14);
                //             $new_number = $codenumber . "0000" . strval(intval($count) + $im);
                //         }   
                //         elseif(intval($newnumber2) > 8 && intval($newnumber2) < 99)
                //         {
                //             $count = substr($newnumber2,13);
                //             $new_number = $codenumber . "000" . strval(intval($count) + $im);
                //         }
                //         elseif(intval($newnumber2) > 98 && intval($newnumber2) < 999)
                //         {
                //             $count = substr($newnumber2,12);
                //             $new_number = $codenumber . "00" . strval(intval($count) + $im);
                //         }
                //         elseif(intval($newnumber2) > 998 && intval($newnumber2) < 9999)
                //         {
                //             $count = substr($newnumber2,11);
                //             $new_number = $codenumber . "0" . strval(intval($count) + $im);
                //         }
                //         elseif(intval($newnumber2) > 9998 && intval($newnumber2) < 99999)
                //         {
                //             $count = substr($newnumber2,10);
                //             $new_number = $codenumber  . strval(intval($count) + $im);
                //         }
                        
                //         $im++;

                //     }
                //     else
                //     {
                //         $kondisi=1;
                //     }    
                // } 

                


    
                
            }

            

        }
        else
        {


            $notification = array(
                'message' => 'Fire & Engginering Slip added Failed!, missing data',
                'alert-type' => 'Failed'
            );

            return response($notification);
        }
    }



    public function storeendorsementfeslip(Request $request)
    {
        $validator = $request->validate([
            'slipid'=>'required'
        ]);
        

        if($validator)
        {
            $user = Auth::user();
            
            $slipdata= SlipTable::where('id','=',$request->slipid)->first();
            $slipdatalist= SlipTable::where('insured_id','=',$slipdata->insured_id)->where('selisih','=','false')->get();
            $insureddata = Insured::where('number','=',$slipdata->insured_id)->where('count_endorsement',$slipdata->endorsment)->first();

            // $id_ed = ($slipdata->id + 1);
            $id_ed = ($slipdata->endorsment + 1);
            
            $slipdatalast= SlipTable::where('endorsment',$id_ed)->where('id','=',$request->slipid)->first();
            // dd($slipdatalast);
            // $interestlist= InterestInsuredTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
            $installmentlist= InstallmentTemp::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $deductiblelist= DeductibleTemp::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $retrocessionlist=RetrocessionTemp::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $locationlist= TransLocationTemp::where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();
            $attachmentlist=SlipTableFile::where('slip_id','=',$slipdata->number)->where('insured_id','=',$slipdata->insured_id)->where('slip_type','=','fe')->orderby('id','desc')->get();


            if($slipdata==null)
            {
                $notification = array(
                    'message' => 'Fire & Engineering Slip Endorsement Fail!',
                    'alert-type' => 'danger'
                );
            }
            else
            {
                
                if($slipdatalast == null)
                {

                    $locationlistup = ' ';
                    $risklocationlistup = ' ';
                    $dtlistup = ' ';
                    $jsondtlistup = ' ';
                    $ectlistup = ' ';
                    $jsonectlistup = ' ';
                    $iptlistup = ' ';
                    $jsoniptlistup = ' ';
                    $rctlistup = ' ';
                    $jsonrctlistup = ' ';
                    $risklocationlistdetail = '';

                    if(!empty($locationlist))
                    {
                        foreach($locationlist as $ll)
                        {
                            $locationlistup = TransLocationTemp::create([
                                'insured_id'=>$ll->insured_id,
                                'lookup_location_id'=>$ll->lookup_location_id,
                                'country_id'=>$ll->country_id,
                                'state_id'=>$ll->state_id,
                                'city_id'=>$ll->city_id,
                                'address_location_id'=>$ll->address_location_id,
                                'count_endorsement' => ($ll->count_endorsement + 1)
                            ]);
    
                            $lookuplocationlist = DB::table('trans_location_detail')
                                                    ->join('fe_lookup_location', 'fe_lookup_location.id', '=', 'trans_location_detail.lookup_location_id')
                                                    ->select('trans_location_detail.*', 'fe_lookup_location.address','fe_lookup_location.loc_code','fe_lookup_location.latitude','fe_lookup_location.longtitude','fe_lookup_location.postal_code')
                                                    ->where('trans_location_detail.id',$locationlistup->id)
                                                    ->get();

                            
                            
                            $risklocationlist= RiskLocationDetail::where('translocation_id','=',$ll->id)->orderby('id','desc')->get();
                            if($risklocationlist != null){
                                foreach($risklocationlist as $rl){
                                    $risklocationlistup = RiskLocationDetail::create([
                                        'ceding_id'=>$rl->ceding_id,
                                        'translocation_id'=>$locationlistup->id,
                                        'interest_id'=>$rl->interest_id,
                                        'cndn'=>$rl->cndn,
                                        'certno'=>$rl->certno,
                                        'slipno'=>$rl->slipno,
                                        'amountlocation'=>$rl->amountlocation,
                                        'count_endorsement' => ($rl->count_endorsement + 1)
                                    ]);
        
                                    $rldata =  RiskLocationDetail::findOrFail($rl->id);
                                    $rldata->amountlocation = ($rl->amountlocation * (-1));
                                    $rldata->save();
        
                                    $risklocationlistdetail = DB::table('risk_location_detail')
                                                            ->join('interest_insured', 'interest_insured.id', '=', 'risk_location_detail.interest_id')
                                                            ->join('ceding_broker', 'ceding_broker.id', '=', 'risk_location_detail.ceding_id')
                                                            ->select('risk_location_detail.*', 'interest_insured.description','ceding_broker.name')
                                                            ->where('risk_location_detail.id',$risklocationlistup->id)
                                                            ->get();
                                }
                            }
    
                        }
                    }

                    if($deductiblelist != null){
                        foreach($deductiblelist as $dt){
                            $dtlistup = DeductibleTemp::create([
                                'deductibletype_id'=>$dt->deductibletype_id,
                                'currency_id'=>$dt->currency_id,
                                'percentage'=>$dt->percentage,
                                'min_claimamount'=>$dt->min_claimamount,
                                'amount'=>$dt->amount,
                                'slip_id'=>$dt->slip_id,
                                'count_endorsement' => ($dt->count_endorsement + 1)
                            ]);

                            $jsondtlistup = DeductibleTemp::where('slip_id','=',$dtlistup->slip_id)->where('count_endorsement',$dtlistup->count_endorsement)->orderby('id','desc')->get();
    
                            $dtdata =  DeductibleTemp::findOrFail($dt->id);
                            $dtdata->min_claimamount = ($dt->min_claimamount * (-1));
                            $dtdata->amount = ($dt->amount * (-1));
                            $dtdata->save();
                        }
                    }else{
                        $dtlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if($extendcoveragelist != null){
                        foreach($extendcoveragelist as $ect){
                            $ectlistup = ExtendCoverageTemp::create([
                                'extendcoverage_id'=>$ect->extendcoverage_id,
                                'percentage'=>$ect->percentage,
                                'amount'=>$ect->amount,
                                'slip_id'=>$ect->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsonectlistup = ExtendCoverageTemp::where('slip_id','=',$ectlistup->slip_id)->where('count_endorsement',$ectlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $ectdata =  ExtendCoverageTemp::findOrFail($ect->id);
                            $ectdata->amount = ($ect->amount * (-1));
                            $ectdata->save();
                        }
                    }else{
                        $ectlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if($installmentlist != null){
                        foreach($installmentlist as $ipt){
                            $iptlistup = InstallmentTemp::create([
                                'installment_date'=>$ipt->installment_date,
                                'percentage'=>$ipt->percentage,
                                'amount'=>$ipt->amount,
                                'slip_id'=>$ipt->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsoniptlistup = InstallmentTemp::where('slip_id','=',$iptlistup->slip_id)->where('count_endorsement',$iptlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $iptdata =  InstallmentTemp::findOrFail($ipt->id);
                            $iptdata->amount = ($ipt->amount * (-1));
                            $iptdata->save();
                        }
                    }
                    else{
                        $iptlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);
                    }

                    if(!$retrocessionlist){
                        $rctlistup = json([
                            'message' => ' data not found ',
                            'value' => ' '
                        ]);

                    }
                    else{
                       
                        foreach($retrocessionlist as $rct){
                            $rctlistup = RetrocessionTemp::create([
                                'type'=>$rct->type,
                                'contract'=>$rct->contract,
                                'percentage'=>$rct->percentage,
                                'amount'=>$rct->amount,
                                'slip_id'=>$rct->slip_id,
                                'count_endorsement' => ($ect->count_endorsement + 1)
                            ]);

                            $jsonrctlistup = RetrocessionTemp::where('slip_id','=',$rctlistup->slip_id)->where('count_endorsement',$rctlistup->count_endorsement)->orderby('id','desc')->get();

    
                            $rctdata =  RetrocessionTemp::findOrFail($rct->id);
                            $rctdata->amount = ($rct->amount * (-1));
                            $rctdata->save();
                        }
                    }
                    

                    if($slipdatalist != null)
                    {
                        if($jsondtlistup == ' '){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'fe',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        // 'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>json_encode($jsoniptlistup),
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc,
                                        'remarks'=>$slt->$remarks
                    
                                    ]);
                            }
                        }elseif($jsonectlistup == ' ' ){
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'fe',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        // 'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>json_encode($jsoniptlistup),
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc,
                                        'remarks'=>$slt->$remarks
                    
                                    ]);
                            }
                        }
                        elseif($jsoniptlistup == ' ')
                        {
                            foreach($slipdatalist as $slt){
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'fe',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        // 'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'retrocession_panel'=>json_encode($jsonrctlistup),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc,
                                        'remarks'=>$slt->$remarks
                    
                                    ]);
                            }
                        }
                        elseif($jsonrctlistup == ' ')
                        {
                            foreach($slipdatalist as $slt)
                            {
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'fe',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        // 'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>$jsoniptlistup->toJson(),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc,
                                        'remarks'=>$slt->$remarks
                    
                                    ]);
                            }
                        
                        }
                        else
                        {
                            foreach($slipdatalist as $slt)
                            {
                                $slipdataup = SlipTable::create([
                                        'number'=>$slt->number,
                                        'username'=>$slt->username,
                                        'insured_id'=>$slt->insured_id,
                                        'slip_type'=>'fe',
                                        'prod_year' => $slt->prod_year,
                                        'selisih' => 'true',
                                        'date_transfer'=>$slt->slipdatetransfer,
                                        'status'=>$slt->status,
                                        'endorsment'=>($slt->endorsement + 1),
                                        'selisih'=>'true',
                                        'source'=>$slt->source,
                                        'source_2'=>$slt->source_2,
                                        // 'currency'=>$slt->currency,
                                        'cob'=>$slt->cob,
                                        'koc'=>$slt->koc,
                                        'occupacy'=>$slt->occupacy,
                                        'build_const'=>$slt->build_const,
                                        'attacment_file'=>json_encode($attachmentlist),
                                        'total_sum_insured'=>$slt->total_sum_insured,
                                        'insured_type'=>$slt->insured_type,
                                        'insured_pct'=>$slt->insured_pct,
                                        'total_sum_pct'=>$slt->total_sum_pct,
                                        'deductible_panel'=>json_encode($jsondtlistup),
                                        'extend_coverage'=>json_encode($jsonectlistup),
                                        'insurance_period_from'=>$slt->insurance_period_from,
                                        'insurance_period_to'=>$slt->insurance_period_to,
                                        'reinsurance_period_from'=>$slt->reinsurance_period_from,
                                        'reinsurance_period_to'=>$slt->reinsurance_period_to,
                                        'proportional'=>$slt->proportional,
                                        'layer_non_proportional'=>$slt->layer_non_proportional,
                                        'rate'=>$slt->rate,
                                        'v_broker'=>$slt->v_broker,
                                        'share'=>$slt->share,
                                        'sum_share'=>$slt->sum_share,
                                        'basic_premium'=>$slt->basic_premium,
                                        'commission'=>$slt->commission,
                                        'grossprm_to_nr'=>$slt->grossprm_to_nr,
                                        'netprm_to_nr'=>$slt->netprm_to_nr,
                                        'sum_commission'=>$slt->sum_commission,
                                        'installment_panel'=>$jsoniptlistup->toJson(),
                                        'retrocession_panel'=>$jsonrctlistup->toJson(),
                                        'retro_backup'=>$slt->retro_backup,
                                        'own_retention'=>$slt->own_retention,
                                        'sum_own_retention'=>$slt->sum_own_retention,
                                        'wpc'=>$slt->wpc,
                                        'remarks'=>$slt->$remarks
                    
                                    ]);
                            }
                        }
                    }

                    

                    $insureddataup = Insured::create([
                        'number'=>$insureddata->number,
                        'slip_type'=>'fe',
                        'insured_prefix' => $insureddata->insured_prefix,
                        'insured_name'=>$insureddata->insured_name,
                        'insured_suffix'=>$insureddata->insured_suffix,
                        'share'=>$insureddata->share,
                        'share_from'=>$insureddata->share_from,
                        'share_to'=>$insureddata->share_to,
                        'coincurance'=>$insureddata->coincurance,
                        'location'=>$lookuplocationlist->toJson(),
                        'uy'=>$insureddata->uy,
                        'count_endorsement' => ($insureddata->count_endorsement + 1)
                    ]);
    
                    $notification = array(
                        'message' => 'Fire & Enginering Slip added Endorsement successfully!',
                        'alert-type' => 'success'
                    );


                    

                    $msdata = SlipTable::findOrFail($slipdata->id);
                    $msdata->total_sum_insured=($slipdata->total_sum_insured * (-1));
                    $msdata->total_sum_pct=($slipdata->total_sum_pct * (-1));
                    $msdata->sum_share=($slipdata->sum_share * (-1));
                    $msdata->basic_premium=($slipdata->basic_premium * (-1));
                    $msdata->commission=($slipdata->commission * (-1));
                    $msdata->grossprm_to_nr=($slipdata->grossprm_to_nr * (-1));
                    $msdata->netprm_to_nr=($slipdata->netprm_to_nr * (-1));
                    $msdata->sum_commission=($slipdata->sum_commission * (-1));
                    $msdata->wpc=($slipdata->wpc * (-1)); 
                    $msdata->sum_own_retention=($slipdata->sum_own_retention * (-1));
                    $msdata->selisih="false"; 
                    $msdata->save();



                    $insdata =  Insured::findOrFail($insureddata->id);
                    $insdata->share_from = ($insureddata->share_from * (-1));
                    $insdata->share_to = ($insureddata->share_to * (-1));
                    $insdata->save();

                    $cedingbroker = CedingBroker::where('id',$slipdataup->source)->first();
                    $ceding = CedingBroker::where('id',$slipdataup->source_2)->first();
                    
                    $slipdatalist2= SlipTable::where('insured_id','=',$slipdata->insured_id)->get();

                    //$locationlist2= TransLocationTemp::where('insured_id','=',$code_ms)->orderby('id','desc')->get();

        
                    $slipdatalist=array();
                    foreach($slipdatalist2 as $datadetail)
                    {
                        if($datadetail->cedingbroker)
                        {
                            $dataceding=CedingBroker::where('id','=',$datadetail->source)->first();
                            $datadetail->cedingbroker = $dataceding->name;
                            $datadetail->ceding = $dataceding->name;
                            
                        }
                        else
                        {
                            $dataceding=CedingBroker::where('id','=',$datadetail->source)->first();
                            $datadetail->cedingbroker = $dataceding->name;
                            $datadetail->ceding = $dataceding->name;
                        }


                       

                        $slipdatalist[]= $datadetail;
                    }

                
                    return response()->json(
                        [
                            'slip_data' => $slipdataup->toJson(),
                            'slip_dataarray' => json_encode($slipdatalist),
                            'insured_data' => $insureddataup->toJson(),
                            'location_data' => $lookuplocationlist->toJson(),
                            'risklocation_data' => $risklocationlistdetail->toJson(),
                        ]
                    );

                }
                else
                {
                    $notification = array(
                        'message' => 'Fire & Enginering Slip added Endorsement Failed! data already endorsed!',
                        'alert-type' => 'error'
                    );

                    return response()->json(
                        $notification
                    );

                }
            }
        
        }
        else
        {

            $notification = array(
                'message' => 'Fire & Engginering Slip added Failed!',
                'alert-type' => 'success'
            );

            return back()->with($validator)->withInput();
            //Session::flash('Failed', 'Fire & Engginering Insured Failed added', 'danger');
            //return redirect()->route('liniusaha.index');
        }
        
    }

    
    public function storelocationlist(Request $request)
    {

            $adrress = $request->adrress;
            $insured_id = $request->insuredID;
        
            if($adrress !='' && $insured_id != '')
            {    
                $locationlist = new TransLocationTemp();
                $locationlist->insured_id = $insured_id;
                $locationlist->lookup_location_id = $adrress;
                $locationlist->country_id=$request->country;
                $locationlist->state_id=$request->state;
                $locationlist->city_id=$request->city;
                $locationlist->address_location_id=$adrress;
                $locationlist->interest_id=$request->slipinterestid;
                $locationlist->save();

                $felookuplocations = FeLookupLocation::find($adrress);
                $locationlist2 = TransLocationTemp::where('id','=',$locationlist->id);

                return response()->json([
                    'id' => $locationlist->id,
                    'loc_code' => $felookuplocations->loc_code,
                    'address' => $felookuplocations->address,
                    'city_id' => $felookuplocations->city_id,
                    'postal_code' => $felookuplocations->postal_code,
                    'province_id' => $felookuplocations->province_id,
                    'latitude' => $felookuplocations->latitude,
                    'longtitude' => $felookuplocations->longtitude,
                    'state_name' => $felookuplocations->state->name,
                    'city_name' => $felookuplocations->city->name
                    //'interest_id'=> $request->slipinterestid,
                    //'interest_name'=> $locationlist->interestdata->code.'-'.$locationlist->interestdata->description,
                    //'cnno' => $request->cnno,
                    //'certno' => $request->certno,
                    //'refno' => $request->refno,
                    //'amountlocation' => $request->amountlocation,
                ]);
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

    public function storedetaillocation(Request $request)
    {

            $amountlocation = $request->amountlocation;
            $translocation_id = $request->insurednoloc;
        
            if($amountlocation !='' && $translocation_id != '')
            {    
                $locationlist = new RiskLocationDetail();
                $locationlist->translocation_id = $translocation_id;
                $locationlist->ceding_id=$request->ceding_id;
                $locationlist->interest_id=$request->slipinterestid;
                $locationlist->cndn=$request->cndn;
                $locationlist->certno=$request->certno;
                $locationlist->slipno=$request->slipno;
                $locationlist->policyno=$request->policyno;
                $locationlist->percentage=$request->percent_ceding;
                $locationlist->amountlocation=$request->amountlocation;
                $locationlist->save();

                //$felookuplocations = FeLookupLocation::find($adrress);
                $locationlist2 = RiskLocationDetail::where('id','=',$locationlist->id);

                $cedingbroker = CedingBroker::where('id',$request->ceding_id)->first();
                $ceding = CedingBroker::where('id',$request->ceding_id)->first();

                // if($request->kurs == '' || empty($request->kurs))
                // {
                //     $currency = Currency::where('code', '=', 'IDR')->where('country','=','102')->first();
                // }
                // else
                // {
                //     $currency = Currency::where('id', '=', $request->kurs)->first();
                // }

                return response()->json([
                    'id' => $locationlist->id,
                    'translocation_id'=>  $request->translocation_id,
                    'interest_id'=> $request->slipinterestid,
                    'ceding' => $ceding->name,
                    'cedinglocation' => $locationlist->ceding_id,
                    'cedingbroker' => $cedingbroker->name,
                    'interest_name'=> $locationlist->interestdata->code.'-'.$locationlist->interestdata->description,
                    'cndn' => $request->cndn,
                    'certno' => $request->certno,
                    'slipno' => $request->slipno,
                    'policyno' => $request->policyno,
                    'percent' => $request->percent_ceding,
                    'amountlocation' => $request->amountlocation
                    // 'kurs'=> $currency->code
                ]);
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



    public function update(Request $request, $felookuplocation)
    {
        $validator = $request->validate([
            'loc_code'=>'required|max:15,code',
            'address'=>'required',
            'country_id'=>'required',
            'postal_code'=>'required',
            'eq_zone'=>'required',
            'flood_zone'=>'required'
        ]);

        if($validator){
            
            /*
            $felookuplocation->loc_code = $request->loccodefe;
            $felookuplocation->address = $request->addressfe;
            $felookuplocation->longtitude = $request->longtitudefe;
            $felookuplocation->latitude = $request->latitudefe;
            $felookuplocation->postal_code = $request->postal_codefe;
            $felookuplocation->country_id = $request->countryfe;
            $felookuplocation->province_id = $request->statefe;
            $felookuplocation->city_id = $request->cityfe;
            $felookuplocation->eq_zone = $request->eqzonefe;
            $felookuplocation->flood_zone = $request->floodzonefe;
            $felookuplocation->insured = $request->insuredfe;
            $felookuplocation->save();
            */

            $data=$request->all();
            $felookuplocations = FeLookupLocation::find($felookuplocation);
            $felookuplocations->update($data);

            $notification = array(
                'message' => 'Fire & Engineering Lookup Location updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    
    public function updateendorsement(Request $request){

        $slipdata= SlipTable::where('id','=',$request->slipid)->first();

        $interestlist= InterestInsuredTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
        $installmentlist= InstallmentTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
        $extendcoveragelist= ExtendCoverageTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
        $deductiblelist= DeductibleTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
        $retrocessionlist=RetrocessionTemp::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();
        $attachmentlist=SlipTableFile::where('slip_id','=',$slipdata->number)->orderby('id','desc')->get();

        $currdate = date("d/m/Y");

        $slipdataid=$slipdata->id;
        $slipdataup = SlipTable::findOrFail($slipdataid);
        
        $slipdataup->number=$request->slipnumber;
        $slipdataup->username=Auth::user()->name;
        $slipdataup->insured_id=$request->code_ms;
        $slipdataup->prod_year=$currdate;
        $slipdataup->date_transfer=$request->slipdatetransfer;
        $slipdataup->status=$request->slipstatus;
        $slipdataup->endorsment=$request->sliped;
        $slipdataup->selisih=$request->slipsls;
        $slipdataup->source=$request->slipcedingbroker;
        $slipdataup->source_2=$request->slipceding;
        // $slipdataup->currency=$request->slipcurrency;
        $slipdataup->cob=$request->slipcob;
        $slipdataup->koc=$request->slipkoc;
        $slipdataup->occupacy=$request->slipoccupacy;
        $slipdataup->build_const=$request->slipbld_const;
        $slipdataup->slip_no=$request->slipno; 
        $slipdataup->cn_dn=$request->slipcndn; 
        $slipdataup->policy_no=$request->slippolicy_no; 
        $slipdataup->attacment_file= $attachmentlist->toJSon(); 
        $slipdataup->interest_insured=$interestlist->toJSon();
        $slipdataup->total_sum_insured=$request->sliptotalsum; 
        $slipdataup->insured_type=$request->sliptype; 
        $slipdataup->insured_pct=$request->slippct; 
        $slipdataup->total_sum_pct=$request->sliptotalsumpct; 
        $slipdataup->deductible_panel=$deductiblelist->toJson(); 
        $slipdataup->extend_coverage=$extendcoveragelist->toJson();  
        $slipdataup->insurance_period_from=$request->slipipfrom;  
        $slipdataup->insurance_period_to=$request->slipipto;  
        $slipdataup->reinsurance_period_from=$request->sliprpfrom;  
        $slipdataup->reinsurance_period_to=$request->sliprpto;
        $slipdataup->proportional=$request->slipproportional;
        $slipdataup->layer_non_proportional=$request->sliplayerproportional;  
        $slipdataup->rate=$request->sliprate; 
        $slipdataup->v_broker=$request->slipvbroker;
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
        $slipdataup->wpc=$request->wpc;
        
        $countendorsement = $slipdata->endorsment + 1;

        $slipdataup->endorsment=$countendorsement;
        $slipdataup->remarks=@$request->$remarks;
        
        $slipdataup->prev_endorsement=$request->prevslipnumber;
        $slipdataup->sum_own_retention=$request->slipsumor;

        $slipdataup->save();

        // InterestInsuredTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
        InstallmentTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
        ExtendCoverageTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
        DeductibleTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));
        RetrocessionTemp::where('slip_id','=',$request->prevslipnumber)->update(array('slip_id' => $request->slipnumber));          


        $notification = array(
            'message' => 'Fire & Engginering Slip Update Endorsement successfully!',
            'alert-type' => 'success'
        );

        StatusLog::create([
            'status'=>$request->slipstatus,
            'user'=>Auth::user()->name,
            'insured_id'=>$request->code_ms,
            'slip_id'=>$request->slipnumber,
        ]);

        $cedingbroker = CedingBroker::where('id',$slipdataup->source)->first();
        $ceding = CedingBroker::where('id',$slipdataup->source_2)->first();

        return response()->json(
            [
                'id' => $slipdataup->id,
                'number' => $slipdataup->number,
                'slipuy' => $slipdataup->uy,
                'ceding' => $ceding->name,
                'cedingbroker' => $cedingbroker->name,
                'slipstatus' => $slipdataup->status
            ]
        );
    }


    public function destroy($id)
    {
        $insured = Insured::find($id);
        if($insured->delete())
        {
            $slip = SlipTable::where('insured_id', '=', $id);
            $slip->delete();

            $notification = array(
                'message' => 'Fire & Engginering Insured & Slip deleted successfully!',
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

    
    public function destroysliplocationlist($id)
    {
        $sliplistlocation = TransLocationTemp::find($id);
        $amountlocation = '0';
        $sliplistlocation->delete();
        
        return response()->json(['success'=>'Data has been deleted','amountlocation'=>$amountlocation]);
    }


    public function destroysliplocationdetail($id)
    {
        $sliplistlocation = RiskLocationDetail::find($id);
        $amountlocation = $sliplistlocation->amountlocation;
        $cedinglocation = $sliplistlocation->ceding_id;
        $sliplistlocation->delete();
        
        return response()->json(['success'=>'Data has been deleted','amountlocation'=>$amountlocation,'cedinglocation'=>$cedinglocation]);
    }

    
}
