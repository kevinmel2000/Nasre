<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Customer\Customer;
use App\Models\FeLookupLocation;
use App\Models\EarthQuakeZone;
use App\Models\FloodZone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeLookupLocationController extends Controller
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

    

    public function getCountCode(Request $request)
    {
        $code=$request->code;

        $lastid = FeLookupLocation::orderby('id','desc');
    
        if($lastid != null)
        {
              // $code_st = $mydate . strval($lastid + 1);
              if($lastid < 9){
                  $code_felookuplocation = '00000000' . strval($lastid + 1);
              }elseif($lastid > 8 && $lastid < 99){
                  $code_felookuplocation = '0000000' . strval($lastid + 1);
              }elseif($lastid > 98 && $lastid < 999){
                  $code_felookuplocation = '000000' . strval($lastid + 1);
              }elseif($lastid > 998 && $lastid < 9999){
                  $code_felookuplocation = '00000' . strval($lastid + 1);
              }
              elseif($lastid > 9998 && $lastid < 99999){
                  $code_felookuplocation = '0000' . strval($lastid + 1);
              }
              elseif($lastid > 99998 && $lastid < 999999){
                  $code_felookuplocation = '000' . strval($lastid + 1);
              }
              elseif($lastid > 999998 && $lastid < 9999999){
                  $code_felookuplocation = '00' . strval($lastid + 1);
              }
              elseif($lastid > 9999998 && $lastid < 99999999){
                  $code_felookuplocation = '0' . strval($lastid + 1);
              }
              elseif($lastid > 99999998 && $lastid < 999999999){
                  $code_felookuplocation =  strval($lastid + 1);
              }


        }
        else{
              $code_felookuplocation = '00000' . strval(1);
        }


        $data2 = [];

        $data2[] = [
            'codecount' => $code_felookuplocation
        ];

        
        return response()->json($data2);
    }
  

    public function getLocCountCode($code)
    {
        
        $lastid = FeLookupLocation::where('loc_code','like',$code.'%')->count();
    
        if($lastid != null)
        {
              // $code_st = $mydate . strval($lastid + 1);
              if($lastid < 9){
                  $code_felookuplocation = '00000000' . strval($lastid + 1);
              }elseif($lastid > 8 && $lastid < 99){
                  $code_felookuplocation = '0000000' . strval($lastid + 1);
              }elseif($lastid > 98 && $lastid < 999){
                  $code_felookuplocation = '000000' . strval($lastid + 1);
              }elseif($lastid > 998 && $lastid < 9999){
                  $code_felookuplocation = '00000' . strval($lastid + 1);
              }
              elseif($lastid > 9998 && $lastid < 99999){
                  $code_felookuplocation = '0000' . strval($lastid + 1);
              }
              elseif($lastid > 99998 && $lastid < 999999){
                  $code_felookuplocation = '000' . strval($lastid + 1);
              }
              elseif($lastid > 999998 && $lastid < 9999999){
                  $code_felookuplocation = '00' . strval($lastid + 1);
              }
              elseif($lastid > 9999998 && $lastid < 99999999){
                  $code_felookuplocation = '0' . strval($lastid + 1);
              }
              elseif($lastid > 99999998 && $lastid < 999999999){
                  $code_felookuplocation =  strval($lastid + 1);
              }


        }
        else
        {
              $code_felookuplocation = '00000' . strval(1);
        }


        $data2 = [];

        $data2[] = [
            'codecount' => $code.''.$code_felookuplocation
        ];

        
        return response()->json($data2);
    }
  

    
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'Fire & Engineering Lookup Location';   
         $mydate = date("Y").date("m").date("d");
         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $felookuplocation = FeLookupLocation::orderby('id','desc')->paginate(10);
          $felookuplocation_ids = response()->json($felookuplocation->modelKeys());
          $country = Country::orderby('id','asc')->get();
          $city = City::orderby('id','asc')->get();
          $state = State::orderby('id','asc')->get();
          $earthquakezone = EarthQuakeZone::orderby('id','asc')->get();
          $floodzone = FloodZone::orderby('id','asc')->get();
          $costumer=Customer::orderby('id','asc')->get();

          $lastid = count(FeLookupLocation::all());

          if($lastid != null)
          {
              // $code_st = $mydate . strval($lastid + 1);

              if($lastid < 9){
                  $code_felookuplocation = '00000000' . strval($lastid + 1);
              }elseif($lastid > 8 && $lastid < 99){
                  $code_felookuplocation = '0000000' . strval($lastid + 1);
              }elseif($lastid > 98 && $lastid < 999){
                  $code_felookuplocation = '000000' . strval($lastid + 1);
              }elseif($lastid > 998 && $lastid < 9999){
                  $code_felookuplocation = '00000' . strval($lastid + 1);
              }
              elseif($lastid > 9998 && $lastid < 99999){
                  $code_felookuplocation = '0000' . strval($lastid + 1);
              }
              elseif($lastid > 99998 && $lastid < 999999){
                  $code_felookuplocation = '000' . strval($lastid + 1);
              }
              elseif($lastid > 999998 && $lastid < 9999999){
                  $code_felookuplocation = '00' . strval($lastid + 1);
              }
              elseif($lastid > 9999998 && $lastid < 99999999){
                  $code_felookuplocation = '0' . strval($lastid + 1);
              }
              elseif($lastid > 99999998 && $lastid < 999999999){
                  $code_felookuplocation =  strval($lastid + 1);
              }

          }
          else{
              $code_felookuplocation = '00000' . strval(1);
          }

          return view('crm.master.felookuplocation', compact('user','code_felookuplocation','earthquakezone','floodzone','felookuplocation','costumer','route_active','felookuplocation_ids','country','city','state'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $felookuplocation_ids = response()->json($felookuplocation->modelKeys());
          $country = Country::orderby('id','asc')->get();
          $city = City::orderby('id','asc')->get();
          $state = State::orderby('id','asc')->get();
          $earthquakezone = EarthQuakeZone::orderby('id','asc')->get();
          $floodzone = FloodZone::orderby('id','asc')->get();
          $costumer=Customer::orderby('id','asc')->get();

            $lastid = count(FeLookupLocation::all());

            
          if($lastid != null){
                // $code_st = $mydate . strval($lastid + 1);
              if($lastid < 9){
                  $code_felookuplocation = '00000000' . strval($lastid + 1);
              }elseif($lastid > 8 && $lastid < 99){
                  $code_felookuplocation = '0000000' . strval($lastid + 1);
              }elseif($lastid > 98 && $lastid < 999){
                  $code_felookuplocation = '000000' . strval($lastid + 1);
              }elseif($lastid > 998 && $lastid < 9999){
                  $code_felookuplocation = '00000' . strval($lastid + 1);
              }
              elseif($lastid > 9998 && $lastid < 99999){
                  $code_felookuplocation = '0000' . strval($lastid + 1);
              }
              elseif($lastid > 99998 && $lastid < 999999){
                  $code_felookuplocation = '000' . strval($lastid + 1);
              }
              elseif($lastid > 999998 && $lastid < 9999999){
                  $code_felookuplocation = '00' . strval($lastid + 1);
              }
              elseif($lastid > 9999998 && $lastid < 99999999){
                  $code_felookuplocation = '0' . strval($lastid + 1);
              }
              elseif($lastid > 99999998 && $lastid < 999999999){
                  $code_felookuplocation =  strval($lastid + 1);
              }

            }
            else{
                $code_felookuplocation = '00000' . strval(1);
            }

            

          return view('crm.master.felookuplocation', compact('user','code_felookuplocation','earthquakezone','floodzone','felookuplocation','costumer','route_active','felookuplocation_ids','country','city','state'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }


    public function store(Request $request)
    {
        $validator = $request->validate([
            'code'=>'required|max:15,code',
            'address'=>'required',
            'crccountry'=>'required',
            'postal_code'=>'required',
            'eqzone'=>'required',
            'floodzone'=>'required'
        ]);
        
        if($validator)
        {
            $user = Auth::user();
            FeLookupLocation::create([
                'loc_code'=>$request->code,
                'address' => $request->address,
                'longtitude'=>$request->longtitude,
                'latitude'=>$request->latitude,
                'postal_code'=>$request->postal_code,
                'country_id'=>$request->crccountry,
                'city_id'=>$request->cityinsert,
                'province_id'=>$request->province,
                'eq_zone'=>$request->eqzone,
                'flood_zone'=>$request->floodzone,
                'insured'=>$request->insured
            ]);
            $notification = array(
                'message' => 'Fire & Engginering Lookup Location added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
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

    public function destroy($id)
    {
        $felookuplocation = FeLookupLocation::find($id);
        if($felookuplocation->delete())
        {
            $notification = array(
                'message' => 'Fire & Engginering Lookup Location deleted successfully!',
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
    
}
