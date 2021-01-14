<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Koc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{   
    public function index(Request $request)
    {
         $user = Auth::user();
         $route_active = 'State Data Master';   

         $search = @$request->input('search');

         if(empty($search))
         {
          //$felookuplocation=FeLookupLocation::orderBy('created_at','desc')->paginate(10);
          $state = State::orderby('id','desc')->paginate(10);
          $state_ids = response()->json($state->modelKeys());
          $country = Country::orderby('id','asc')->get();
          return view('crm.master.state', compact('user','state','route_active','state_ids','country'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
         else
         {
          //$felookuplocation=FeLookupLocation::where('loc_code', 'LIKE', '%' . $search . '%')->orWhere('address', 'LIKE', '%' . $search . '%')->orderBy('created_at','desc')->paginate(10);
          $state=State::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->paginate(10);
          $state_ids = response()->json($state->modelKeys());
          $country = Country::orderby('id','asc')->get();
          return view('crm.master.state', compact('user','state','route_active','state_ids','country'))->with('i', ($request->input('page', 1) - 1) * 10);
         }
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required',
            'crccountry'=>'required'
        ]);
        
        if($validator)
        {
            //print_r($request);
            //exit();
            $user = Auth::user();
            State::create([
                'name'=>$request->name,
                'country_id'=>$request->crccountry
            ]);
            $notification = array(
                'message' => 'Province State added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        else
        {
            return back()->with($validator)->withInput();
        }
    }


    public function update(Request $request, State $state)
    {
        $validator = $request->validate([
            'namestate'=>'required|unique:currencies,code',
            'crccountrystate'=>'required'
        ]);
        if($validator){
            $state->name = $request->namestate;
            $state->country_id = $request->crccountrystate;
            $state->save();
            $notification = array(
                'message' => 'State Province updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }
    
    public function destroy($id)
    {
      $states = State::find($id);
      
      if($states->delete())
      {
          $notification = array(
              'message' => 'State Province deleted successfully!',
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

    public function destroy2(State $state)
    {
        if($state->delete())
        {
            $notification = array(
                'message' => 'State Province deleted successfully!',
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