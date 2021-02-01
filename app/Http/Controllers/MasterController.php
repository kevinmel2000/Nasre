<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\COB;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Occupation;
use App\Models\ShipType;
use App\Models\PropertyType;
use App\Models\ConditionNeeded;
use App\Models\Collection;
use App\Models\Construction;
use App\Models\MarineLookup;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexcountry(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Country Data Master';
        $search = @$request->input('search');
        

        // dd($country);
        if(empty($search))
         {
            $country = Country::orderby('id','asc')->get();
            $country_ids = response()->json($country->modelKeys());
            return view('crm.master.country', compact(['route_active', 'country','country_ids']));   
        return view('crm.master.country', compact(['route_active', 'country','country_ids']));        
            return view('crm.master.country', compact(['route_active', 'country','country_ids']));   
         }
        else
        {
          $country = Country::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $country_ids = response()->json($country->modelKeys());
          return view('crm.master.country', compact('user','country','route_active','country_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }


    }

    public function indexcob(Request $request)
    {
        $route_active = 'COB Data Master';
        $user = Auth::user();
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        

        if(empty($search))
         {

            $cob = COB::orderby('id','asc')->get();
            $lastid = count($cob);
            $cob_ids = response()->json($cob->modelKeys());

            if($lastid != null){
                $code_cob = strval($lastid + 1);
                //$code_cob = $mydate . strval($lastid + 1);
                
                // if($lastid->id == 9){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_cob = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_cob = strval($lastid + 1);
                //$code_cob = $mydate . strval(1);
            }

            // dd($country);
        return view('crm.master.cob', compact(['route_active', 'cob','cob_ids','code_cob'])); 

        }
        else
        {
            $cob = COB::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $lastid = COB::select('id')->latest()->first();
            $cob_ids = response()->json($cob->modelKeys());

          return view('crm.master.cob', compact('user','cob','route_active','cob_ids'))->with('i', ($request->input('page', 1) - 1) * 10);

        }

               

    }

    public function indexoccupation(Request $request)
    {
        $route_active = 'Occupation Data Master';
        $user = Auth::user();
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        

        if(empty($search))
         {
            $occupation = Occupation::orderby('id','asc')->get();
            $lastid = count($occupation);
            $ocp_ids = response()->json($occupation->modelKeys());
            $cob = COB::orderby('id','asc')->get();


            if($lastid != null){
                //$code_ocp = $mydate . strval($lastid + 1);
                $code_ocp = strval($lastid + 1);
                
                // if($lastid->id == 9){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_ocp = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_ocp = strval($lastid + 1);
                //$code_ocp = $mydate . strval(1);
            }

        return view('crm.master.occupation', compact(['route_active', 'occupation','cob','ocp_ids','code_ocp']));        

        }
        else
        {
            $occupation =Occupation::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $ocp_ids = response()->json($occupation->modelKeys());
            $cob = COB::orderby('id','asc')->get();


            return view('crm.master.occupation', compact('user','occupation','cob','route_active','ocp_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }


        // dd($lastid);
        // return view('crm.master.occupation', compact(['route_active', 'occupation','cob','ocp_ids','code_ocp']));        

    }

    public function indexcurrency(Request $request)
    {
        $route_active = 'Currency Data Master';
        $user = Auth::user();
        $search = @$request->input('search');

        if(empty($search))
         {
            $currency = Currency::orderby('id','asc')->get();
            $crc_ids = response()->json($currency->modelKeys());
            $country = Country::orderby('id','asc')->get();

            // dd($country);
            return view('crm.master.currency', compact(['route_active', 'currency','crc_ids','country']));        
        }
        else
        {
            $currency = Currency::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $crc_ids = response()->json($currency->modelKeys());
            $country = Country::orderby('id','asc')->get();

            return view('crm.master.currency', compact('user','currency','country','route_active','crc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexexchange(Request $request)
    {
        $route_active = 'Currency Exchange Data Master';
        $user = Auth::user();
        $search = @$request->input('search');

        if(empty($search))
         {
            $currency_exchange = CurrencyExchange::orderby('id','asc')->get();
            $exc_ids = response()->json($currency_exchange->modelKeys());
            $currency = Currency::orderby('id','asc')->get();

            // dd($country);
            return view('crm.master.exchange', compact(['route_active','exc_ids','currency','currency_exchange']));        
        }
        else
        {
            $currency_exchange = CurrencyExchange::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $exc_ids = response()->json($currency_exchange->modelKeys());
            $currency = Currency::orderby('id','asc')->get();

            return view('crm.master.currency', compact('user','currency_exchange','currency','route_active','exc_ids'))->with('i', ($request->input('page', 1) - 1) * 10);

        }

    }

    public function indexshiptype(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Ship Type Data Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        // dd($country);
        if(empty($search))
         {
            $shiptype = ShipType::orderby('id','asc')->get();
            $shiptype_ids = response()->json($shiptype->modelKeys());
            $lastid = count($shiptype);

            if($lastid != null){
                $code_st = $mydate . strval($lastid + 1);

                // if($lastid->id == 9){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_st = $mydate . strval(1);
            }

            return view('crm.master.ship_type', compact(['route_active', 'shiptype','shiptype_ids','code_st']));  
         }
        else
        {
          $shiptype = ShipType::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $shiptype_ids = response()->json($shiptype->modelKeys());
          return view('crm.master.ship_type', compact('user','shiptype','route_active','shiptype_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexclassification(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Classification Data Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        // dd($country);
        if(empty($search))
         {
            $classification = Classification::orderby('id','asc')->get();
            $classification_ids = response()->json($classification->modelKeys());
            $lastid = count($classification);

            if($lastid != null){
                $code_cs = $mydate . strval($lastid + 1);
                
                // if($lastid->id == 9){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_cs = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_cs = $mydate . strval(1);
            }

            return view('crm.master.classification', compact(['route_active', 'code_cs','classification','classification_ids']));   
         }
        else
        {
          $classification = Classification::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $classification_ids = response()->json($classification->modelKeys());
          return view('crm.master.classification', compact('user','classification','route_active','classification_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexconstruction(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Construction Data Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        // dd($country);
        if(empty($search))
         {
            $construction = Construction::orderby('id','asc')->get();
            $construction_ids = response()->json($construction->modelKeys());
            $lastid = count($construction);

            if($lastid != null){
                $code_cr = $mydate . strval($lastid + 1);
                // if($lastid->id == 9){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_cr = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_cr = $mydate . strval(1);
            }
            return view('crm.master.construction', compact(['route_active','code_cr','construction','construction_ids']));   
         }
        else
        {
          $construction = Construction::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $construction_ids = response()->json($construction->modelKeys());
          return view('crm.master.construction', compact('user','construction','route_active','construction_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexmarinelookup(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Marine - Lookup Ship';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");
        $country = Country::orderby('id','asc')->get();
        $shiptype = ShipType::orderby('id','asc')->get();
        $classification = Classification::orderby('id','asc')->get();
        $construction = Construction::orderby('id','asc')->get();


        // dd($country);
        if(empty($search))
         {
            $mlu = MarineLookup::orderby('id','asc')->get();
            $mlu_ids = response()->json($mlu->modelKeys());
            $lastid = count($mlu);

            if($lastid != null){
                $code_mlu = $mydate . strval($lastid + 1);

                // if($lastid->id == 9){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_mlu = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_mlu = $mydate . strval(1);
            }
            return view('crm.master.marine_lookup', compact(['user','country','shiptype','classification','construction','code_mlu','mlu','route_active','mlu_ids']));     
         }
        else
        {
          $mlu = MarineLookup::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $mlu_ids = response()->json($mlu->modelKeys());
          return view('crm.master.marine_lookup', compact('user','country','shiptype','classification','construction','mlu','route_active','mlu_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexpropertytype(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Property Type Data Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        // dd($country);
        if(empty($search))
         {
            $propertytype = PropertyType::orderby('id','asc')->get();
            $propertytype_ids = response()->json($propertytype->modelKeys());
            $lastid = count($propertytype);

            if($lastid != null){
                $code_pt = $mydate . strval($lastid + 1);

                // if($lastid->id == 9){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_pt = $mydate . strval(1);
            }

            return view('crm.master.property_type', compact(['route_active', 'propertytype','propertytype_ids','code_pt']));  
         }
        else
        {
          $propertytype = PropertyType::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $propertytype_ids = response()->json($propertytype->modelKeys());
          return view('crm.master.property_type', compact('user','propertytype','route_active','propertytype_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    public function indexconditionneeded(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Condition Needed Data Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        // dd($country);
        if(empty($search))
         {
            $cdn = ConditionNeeded::orderby('id','asc')->get();
            $cdn_ids = response()->json($cdn->modelKeys());
            $lastid = count($cdn);

            if($lastid != null){
                $code_cdn = $mydate . strval($lastid + 1);

                // if($lastid->id == 9){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 10){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 99){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 100){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id == 999){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }elseif($lastid->id >= 1000){
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }else{
                //     $code_st = $mydate . strval($lastid->id + 1);
                // }
            }
            else{
                $code_cdn = $mydate . strval(1);
            }

            return view('crm.master.condition_needed', compact(['route_active', 'cdn','cdn_ids','code_cdn']));  
         }
        else
        {
          $cdn = PropertyType::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $cdn_ids = response()->json($cdn->modelKeys());
          return view('crm.master.condition_needed', compact('user','cdn','route_active','cdn_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
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
    public function storecountry(Request $request)
    {
        $validator = $request->validate([
            'countryname'=>'required',
            'countrycode'=>'required|max:3',
            'continent'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Country::create([
                'name'=>$request->countryname,
                'code'=>$request->countrycode,
                'continent'=>$request->continent
            ]);
            $notification = array(
                'message' => 'Country added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storecob(Request $request)
    {
        $validator = $request->validate([
            'cobcode'=>'required|max:15|unique:cob,code',
            'cobdescription'=>'required',
            'cobabbreviation'=>'required',
            'cobremarks'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            COB::create([
                'code'=>$request->cobcode,
                'description'=>$request->cobdescription,
                'abbreviation'=>$request->cobabbreviation,
                'parent_id'=>$request->parent_id,
                'remarks'=>$request->cobremarks
            ]);
            $notification = array(
                'message' => 'COB added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeoccupation(Request $request)
    {
        $validator = $request->validate([
            'ocpcode'=>'required|max:15|unique:occupation,code',
            'ocpdescription'=>'required',
            'ocpabbreviation'=>'required',
            'ocpgrouptype'=>'required',
            'ocpcob'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Occupation::create([
                'code'=>$request->ocpcode,
                'description'=>$request->ocpdescription,
                'abbreviation'=>$request->ocpabbreviation,
                'group_type'=>$request->ocpgrouptype,
                'parent_id'=>$request->parent_id,
                'cob'=>$request->ocpcob,
            ]);
            $notification = array(
                'message' => 'Occupation added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storecurrency(Request $request)
    {
        $validator = $request->validate([
            'crccode'=>'required|max:5|unique:currencies,code',
            'crcsymbolname'=>'required',
            'crccountry'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Currency::create([
                'symbol_name'=>$request->crcsymbolname,
                'is_base_currency' => '',
                'code'=>$request->crccode,
                'country'=>$request->crccountry
            ]);
            $notification = array(
                'message' => 'Currency added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeexchange(Request $request)
    {
        $validator = $request->validate([
            'exccurrency'=>'required|max:5|unique:currencies_exc,currency',
            'excmonth'=>'required',
            'excyear'=>'required',
            'exckurs'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            CurrencyExchange::create([
                'currency'=>$request->exccurrency,
                'month' => $request->excmonth,
                'year'=>$request->excyear,
                'kurs'=>$request->exckurs
            ]);
            $notification = array(
                'message' => 'Currency Exchange added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeshiptype(Request $request)
    {
        $validator = $request->validate([
            'stcode'=>'required|max:12|unique:ship_type,code',
            'stname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            ShipType::create([
                'code'=>$request->stcode,
                'name' => $request->stname
            ]);
            $notification = array(
                'message' => 'Ship Type added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeclassification(Request $request)
    {
        $validator = $request->validate([
            'cscode'=>'required|max:12|unique:classification,code',
            'csname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Classification::create([
                'code'=>$request->cscode,
                'name' => $request->csname
            ]);
            $notification = array(
                'message' => 'Classification data added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeconstruction(Request $request)
    {
        $validator = $request->validate([
            'crcode'=>'required|max:12|unique:construction,code',
            'crname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            Construction::create([
                'code'=>$request->crcode,
                'name' => $request->crname
            ]);
            $notification = array(
                'message' => 'Construction Data added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storemarinelookup(Request $request)
    {
        $validator = $request->validate([
            'mlucode'=>'required|max:12|unique:marine_lookup,code',
            'mlushipname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            MarineLookup::create([
                'code'=>$request->mlucode,
                'shipname' => $request->mlushipname,
                'owner' => $request->mluowner,
                'grt' => $request->mlugrt,
                'dwt' => $request->mludwt,
                'nrt' => $request->mlunrt,
                'power' => $request->mlupower,
                'ship_year' => $request->mlushipyear,
                'repair_year' => $request->mlurepairyear,
                'galangan' => $request->mlugalangan,
                'ship_type' => $request->mlushiptype,
                'classification' => $request->mluclassification,
                'construction' => $request->mluconstruction,
                'country' => $request->mlucountry,

            ]);
            $notification = array(
                'message' => 'Marine Lookup added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storepropertytype(Request $request)
    {
        $validator = $request->validate([
            'ptcode'=>'required|max:12|unique:property_type,code',
            'ptname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            PropertyType::create([
                'code'=>$request->ptcode,
                'name' => $request->ptname
            ]);
            $notification = array(
                'message' => 'Property Type added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function storeconditionneeded(Request $request)
    {
        $validator = $request->validate([
            'cdncode'=>'required|max:12|unique:property_type,code',
            'cdnname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            ConditionNeeded::create([
                'code'=>$request->cdncode,
                'name' => $request->cdnname,
                'information' => $request->cdninfo
            ]);
            $notification = array(
                'message' => 'Condition Needed Data added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function updatecountry(Request $request, Country $country)
    {
        $validator = $request->validate([
            'namecountry'=>'required',
            'codecountry'=>'required|max:3',
            'continentcountry'=>'required'
        ]);
        if($validator){
            $country->name = $request->namecountry;
            $country->code = $request->codecountry;
            $country->continent = $request->continentcountry;
            $country->save();
            $notification = array(
                'message' => 'Country updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updatecob(Request $request, COB $cob)
    {
        $validator = $request->validate([
            'codecob'=>'required|max:20',
            'descriptioncob'=>'required',
            'abbreviationcob'=>'required',
            'remarkscob'=>'required'
        ]);
        if($validator){
            $cob->code = $request->codecob;
            $cob->description = $request->descriptioncob;
            $cob->abbreviation = $request->abbreviationcob;
            $cob->parent_id = $request->parent_id;
            $cob->remarks = $request->remarkscob;
            $cob->save();
            $notification = array(
                'message' => 'COB updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updateoccupation(Request $request, Occupation $ocp)
    {
        $validator = $request->validate([
            'codeocp'=>'required|max:20',
            'descriptionocp'=>'required',
            'abbreviationocp'=>'required',
            'grouptypeocp'=>'required',
            'cobocp'=>'required'
        ]);
        if($validator){
            $ocp->code = $request->codeocp;
            $ocp->description = $request->descriptionocp;
            $ocp->abbreviation = $request->abbreviationocp;
            $ocp->group_type = $request->grouptypeocp;
            $ocp->parent_id = $request->parent_id;
            $ocp->cob = $request->cobocp;
            $ocp->save();
            $notification = array(
                'message' => 'Occupation updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

   public function updatecurrency(Request $request, Currency $crc)
   {
    
    $validator = $request->validate([
        'codecrc'=>'required|max:5',
        'symbolnamecrc'=>'required',
        'countrycrc'=>'required'
    ]);
    
    if($validator){
        $crc->symbol_name = $request->symbolnamecrc;
        $crc->code = $request->codecrc;
        $crc->country = $request->countrycrc;
        $crc->save();
        $notification = array(
            'message' => 'Currency updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
   }

   public function updateexchange(Request $request, CurrencyExchange $exc)
   {
    
    $validator = $request->validate([
        'currencyexc'=>'required|max:5',
            'monthexc'=>'required',
            'yearexc'=>'required',
            'kursexc'=>'required'
    ]);
    
    if($validator){
        $exc->currency = $request->currencyexc;
        $exc->month = $request->monthexc;
        $exc->year = $request->yearexc;
        $exc->kurs = $request->kursexc;
        $exc->save();
        $notification = array(
            'message' => 'Currency updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
   }

   public function updateshiptype(Request $request, ShipType $st)
   {
    
        $validator = $request->validate([
            'codest'=>'required|max:12',
                'namest'=>'required'
        ]);
        
        if($validator){
            $st->code = $request->codest;
            $st->name = $request->namest;
            $st->save();
            $notification = array(
                'message' => 'Ship Type updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }

   }

   public function updateclassification(Request $request, Classification $cs)
   {
    
    $validator = $request->validate([
        'codecs'=>'required|max:12',
            'namecs'=>'required'
    ]);
    
    if($validator){
        $cs->code = $request->codecs;
        $cs->name = $request->namecs;
        $cs->save();
        $notification = array(
            'message' => 'Classification updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
    
   }

   public function updateconstruction(Request $request, Construction $cr)
   {
    
    $validator = $request->validate([
        'codecr'=>'required|max:12',
            'namecr'=>'required'
    ]);
    
    if($validator){
        $cr->code = $request->codecr;
        $cr->name = $request->namecr;
        $cr->save();
        $notification = array(
            'message' => 'Construction updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
    
   }

   public function updatemarinelookup(Request $request, MarineLookup $mlu)
   {
    
    $validator = $request->validate([
        'codemlu'=>'required|max:5',
            'shipnamemlu'=>'required'
    ]);
    
    if($validator){
        $mlu->code = $request->codemlu;
        $mlu->shipname = $request->shipnamemlu;
        $mlu->owner = $request->ownermlu;
        $mlu->grt = $request->grtmlu;
        $mlu->dwt = $request->dwtmlu;
        $mlu->nrt = $request->nrtmlu;
        $mlu->power = $request->powermlu;
        $mlu->ship_year = $request->ship_yearmlu;
        $mlu->repair_year = $request->repair_yearmlu;
        $mlu->galangan = $request->galanganmlu;
        $mlu->ship_type = $request->ship_typemlu;
        $mlu->classification = $request->classificationmlu;
        $mlu->construction = $request->constructionmlu;
        $mlu->save();
        $notification = array(
            'message' => 'Marine lookup data updated successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }else{
        return back()->with($validator)->withInput();
    }
    
   }


   public function updatepropertytype(Request $request, PropertyType $pt)
   {
    
        $validator = $request->validate([
            'codept'=>'required|max:12,unique:property_type,code',
                'namept'=>'required'
        ]);
        
        if($validator){
            $pt->code = $request->codept;
            $pt->name = $request->namept;
            $pt->save();
            $notification = array(
                'message' => 'Property Type Data updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }

   }

   public function updateconditionneeded(Request $request, ConditionNeeded $cdn)
   {
    
        $validator = $request->validate([
            'codecdn'=>'required|max:12,unique:condition_needed,code',
                'namecdn'=>'required'
        ]);
        
        if($validator){
            $cdn->code = $request->codecdn;
            $cdn->name = $request->namecdn;
            $cdn->information = $request->infocdn;
            $cdn->save();
            $notification = array(
                'message' => 'Condition Needed Data updated successfully!',
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
    public function destroycountry(Country $country)
    {
        if($country->delete()){
            $notification = array(
                'message' => 'Country deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }


    public function destroycob(COB $cob)
    {
        if($cob->delete()){
            $notification = array(
                'message' => 'COB deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyoccupation(Occupation $ocp)
    {
        if($ocp->delete()){
            $notification = array(
                'message' => 'Occupation deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroycurrency(Currency $crc)
    {
        if($crc->delete()){
            $notification = array(
                'message' => 'Currency deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyExchange(CurrencyExchange $exc)
    {
        if($exc->delete()){
            $notification = array(
                'message' => 'Currency Exchange deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyshiptype(ShipType $st)
    {
        if($st->delete()){
            $notification = array(
                'message' => 'Ship Type deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyclassification(Classification $cs)
    {
        if($cs->delete()){
            $notification = array(
                'message' => 'Classification Data deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyconstruction(Construction $cr)
    {
        if($cr->delete()){
            $notification = array(
                'message' => 'Construction deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroymarinelookup(MarineLookup $mlu)
    {
        if($mlu->delete()){
            $notification = array(
                'message' => 'Marine Lookup Data deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroypropertytype(PropertyType $pt)
    {
        if($pt->delete()){
            $notification = array(
                'message' => 'Property Type Data deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroyconditionneeded(ConditionNeeded $cdn)
    {
        if($cdn->delete()){
            $notification = array(
                'message' => 'Condition Needed Data deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

}
