<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Leads\Lead;
use App\Models\Customer\Customer;
use App\Models\SingleRowData;
use Illuminate\Support\Facades\Schema;

class CRMCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Schema::hasTable('users') || 
            !Schema::hasTable('customers') || 
            !Schema::hasTable('leads') || 
            !Schema::hasTable('products') || 
            !Schema::hasTable('proposals') || 
            !Schema::hasTable('invoices')
        ) {
            session(['total_users' => '', 'total_customers'=>'', 'total_leads'=>'', 'total_products'=>'', 'total_proposals'=>'', 'total_invoices'=>'']);
            return $next($request);
        }
        $users = User::where('id','!=','1')->count();
        $customers = Customer::count();
        $leads = Lead::count();
        $products = Product::count();
        $proposals = Proposal::count();
        $invoices = Invoice::count();
        $logo = SingleRowData::where('field_name','logo_file')->first();
        // dd($logo);
        if($logo != null){
            $logo_file = $logo->field_value;
        }else{
            $logo_file = '';
        }
 
        
        session(['total_users' => $users, 'total_customers'=>$customers, 'total_leads'=>$leads, 'total_products'=>$products, 'total_proposals'=>$proposals, 'total_invoices'=>$invoices, 'logo_file'=>$logo_file ]);
        // dd(session('logo_file'));


        // if LoggedIn user is a client/customer
        if (session('client_id') != null) {
            $proposals = Proposal::where('customer_id',session('client_id'))->count();
            $invoices = Invoice::where('customer_id',session('client_id'))
            ->where('status','!=','draft')
            ->count();
            session(['customer_proposals'=>$proposals, 'customer_invoices'=>$invoices,]);
        }



        return $next($request);
    }
}
