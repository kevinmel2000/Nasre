<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\TaxRate;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Projects\Project;

class ProjectController extends Controller
{

    public function index()
    {
        $route_active = 'project';
        $proposals = Project::get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.project.index', compact(['route_active', 'projects','productGroups','base_currency']));   
    }

    public function create()
    {
        $route_active = 'projectCreate';
        $taxrates = TaxRate::get();
        $currencies = Currency::get();
        $users = User::where('role_id','!=','1')->where('status','active')->get();
        $products = Product::where('status','active')->get();
        return view('crm.project.create', compact(['route_active', 'taxrates','currencies','users','products']));  
    }

}
