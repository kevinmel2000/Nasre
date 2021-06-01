<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormProductController extends Controller
{
    public function indexformproduct()
    {
        $user = Auth::user();
        $route_active = 'Product';
        // $search = @$request->input('search');
        return view('health.data-maintenance.formProduct', compact(['route_active']));

        // // dd($country);
        // if(empty($search))
        //  {
        //     $country = Country::orderby('id','asc')->get();
        //     $country_ids = response()->json($country->modelKeys());
        //     return view('crm.master.country', compact(['route_active', 'country','country_ids']));
        // return view('crm.master.country', compact(['route_active', 'country','country_ids']));
        //     return view('crm.master.country', compact(['route_active', 'country','country_ids']));
        //  }
        // else
        // {
        //   $country = Country::where('code', 'LIKE', '%' . $search . '%')->orderBy('id','desc')->get();
        //   $country_ids = response()->json($country->modelKeys());
        //   return view('crm.master.country', compact('user','country','route_active','country_ids'))->with('i', ($request->input('page', 1) - 1) * 10);
        // }
    }
}
