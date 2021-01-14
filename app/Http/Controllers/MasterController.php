<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\COB;
use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Models\Occupation;
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
            $lastid = COB::select('id')->latest()->first();
            $cob_ids = response()->json($cob->modelKeys());

            if($lastid != null){
                if($lastid->id == 9){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 10){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id == 99){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 100){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id == 999){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 1000){
                    $code_cob = $mydate . strval($lastid->id + 1);
                }else{
                    $code_cob = $mydate . strval($lastid->id + 1);
                }
            }
            else{
                $code_cob = $mydate . strval($lastid->id + 1);
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
            $lastid = Occupation::select('id')->latest()->first();
            $ocp_ids = response()->json($occupation->modelKeys());
            $cob = COB::orderby('id','asc')->get();


            if($lastid != null){
                if($lastid->id == 9){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 10){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id == 99){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 100){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id == 999){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }elseif($lastid->id >= 1000){
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }else{
                    $code_ocp = $mydate . strval($lastid->id + 1);
                }
            }
            else{
                $code_ocp = $mydate . strval($lastid->id + 1);
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

}
