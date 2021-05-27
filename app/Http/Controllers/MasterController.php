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
use App\Models\InterestInsured;
use App\Models\DeductibleType;
use App\Models\ExtendedCoverage;
use App\Models\ShipPort;
use App\Models\RouteShip;
use App\Models\City;
use App\Models\Collection;
use App\Models\Construction;
use App\Models\CompanyType;
use App\Models\MarineLookup;
use App\Models\PrefixInsured;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\DB;
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
        $route_active = 'Country Master';
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
        $route_active = 'COB Master';
        $user = Auth::user();
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        

        if(empty($search))
         {

            $cob = COB::orderby('code')->get();
            $cobparent = COB::whereRaw('LENGTH(code) < 9')->orderby('code','desc')->get();
            // $cobparent = COB::orderby('code')->get();
            $countparent= COB::where('parent_id',null)->whereRaw('LENGTH(code) < 5')->orderby('code','desc')->get();
            // dd($countparent);
            $lastid = count($countparent);
            $cob_ids = response()->json($cob->modelKeys());

            if($lastid != null){

                if($lastid < 9){
                    $code_cob = '0' . strval($lastid + 1);
                }   
                elseif($lastid > 8 && $lastid < 99){
                    $code_cob = strval($lastid + 1);
                } 
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
                $code_cob = '0' . strval(1);
                //$code_cob = $mydate . strval(1);
            }

            // dd($country);
        return view('crm.master.cob', compact(['route_active','cobparent', 'cob','cob_ids','code_cob'])); 

        }
        else
        {
            $cob = COB::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
            $lastid = COB::select('id')->latest()->first();
            $cob_ids = response()->json($cob->modelKeys());

          return view('crm.master.cob', compact('user','cob','route_active','cob_ids'))->with('i', ($request->input('page', 1) - 1) * 10);

        }

               

    }

  

    public function indexcurrency(Request $request)
    {
        $route_active = 'Currency Master';
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
        $route_active = 'Currency Exchange Master';
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


    public function indexcompanytype(Request $request)
    {
        $user = Auth::user();
        $route_active = 'Company Type Master';
        $search = @$request->input('search');
        $mydate = date("Y").date("m").date("d");

        // dd($country);
        if(empty($search))
         {
            $companytype = CompanyType::orderby('id','asc')->get();
            $companytype_ids = response()->json($companytype->modelKeys());
            $lastid = count($companytype);

            if($lastid != null){
                $code_ct = $mydate . strval($lastid + 1);

                if($lastid < 9){
                    $code_ct = '00000' . strval($lastid + 1);
                }elseif($lastid > 8 && $lastid < 99){
                    $code_ct = '0000' . strval($lastid- + 1);
                }elseif($lastid > 98 && $lastid < 999){
                    $code_ct = '000' . strval($lastid + 1);
                }elseif($lastid > 998 && $lastid < 9999){
                    $code_ct = '00' . strval($lastid + 1);
                }elseif($lastid > 9998 && $lastid < 99999){
                    $code_ct = '0' . strval($lastid + 1);
                }elseif($lastid > 99998){
                    $code_ct =  strval($lastid + 1);
                }
            }
            else{
                $code_ct ='00000' . strval(1);
            }

            return view('crm.master.companytype', compact(['route_active', 'companytype','companytype_ids','code_ct']));  
         }
        else
        {
          $companytype = CompanyType::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
          $companytype_ids = response()->json($companytype->modelKeys());
          return view('crm.master.companytype', compact('user','companytype','route_active','companytype_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }



    public function generatecodecob(request $request)
    {
        $cob_parent = COB::where('id',$request->cob_code)->first();
        $cob = COB::where('parent_id',$request->cob_code)->orderby('id','desc')->get();
        $coblastparent = COB::where('parent_id',$request->cob_code)->orderby('id','desc')->first();
        $lastid = count($cob);
        
        if(!$coblastparent){
            $code_cob =  $cob_parent->code . '0' . strval(0);

            return response()->json(
                [
                    'autocode' => $code_cob
                ]
            );
        }
        else{
            
            $parentlastcode = substr($coblastparent->code,2) ;
            // $sumlastcode = strval($parentlastcode + 1);

                if($parentlastcode < 9){
                    $code_cob = $cob_parent->code . '0' . strval($parentlastcode + 1);

                    return response()->json(
                        [
                            'autocode' => $code_cob
                        ]
                    );
                }elseif($parentlastcode > 8 && $parentlastcode < 100){
                    $code_cob = $cob_parent->code . strval($parentlastcode + 1);

                    return response()->json(
                        [
                            'autocode' => $code_cob
                        ]
                    );
                }
        }
       

          
    }

    
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
            'cobabbreviation'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            COB::create([
                'code'=>$request->cobcode,
                'description'=>$request->cobdescription,
                'abbreviation'=>$request->cobabbreviation,
                'parent_id'=>$request->parent_id,
                'remarks'=>$request->cobremarks,
                'form'=>$request->cobform
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

   
    public function storecurrency(Request $request)
    {
        $validator = $request->validate([
            'crccode'=>'required|max:5|unique:currencies,code',
            'crcsymbolname'=>'required',
            'crccountry'=>'required|unique:currencies,country'
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

    
    public function storecompanytype(Request $request)
    {
        $validator = $request->validate([
            'ctcode'=>'required|max:12|unique:company_type,code',
            'ctname'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            CompanyType::create([
                'code'=>$request->ctcode,
                'name' => $request->ctname
            ]);
            $notification = array(
                'message' => 'Company Type added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    

    public function getCityList()
    {
        $cities = DB::table("cities")
        ->orderBy('name')
        ->get()
        ->pluck("name","id");
        return response()->json($cities);
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
            'codecob'=>'max:20',
            'descriptioncob'=>'required',
            'abbreviationcob'=>'required'
        ]);
        if($validator){
            $cob->code = $request->codecob;
            $cob->description = $request->descriptioncob;
            $cob->abbreviation = $request->abbreviationcob;
            $cob->parent_id = $request->parent_id;
            $cob->remarks = $request->remarkscob;
            $cob->form = $request->formcob;
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

  
   public function updatecompanytype(Request $request, CompanyType $ct)
   {
    
        $validator = $request->validate([
            'codect'=>'required|max:12,unique:company_type,code',
                'namect'=>'required'
        ]);
        
        if($validator){
            $ct->code = $request->codect;
            $ct->name = $request->namect;
            $ct->save();
            $notification = array(
                'message' => 'Company Type Data updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }

   }

  
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

    

    public function destroycompanytype(CompanyType $ct)
    {
        if($ct->delete()){
            $notification = array(
                'message' => 'Company Type Data deleted successfully!',
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
