<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SMTP;
use App\Models\Invoice;
use App\Models\Leads\Lead;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $route_active = 'home';
        $total_revenue = Invoice::where('invoice_paid','=','yes')->sum('total_amount');
        $total_leads = $this->count_total_leads();
        if ($total_leads > 0) {
            $won_leads = $this->count_won_leads();
            $won_leads_avg = ($won_leads*100)/$total_leads;
    
            $pending_leads = $this->count_pending_leads();
            $pending_leads_avg = ($pending_leads*100)/$total_leads;
    
            $dead_leads = $this->count_dead_leads();
            $dead_leads_avg = ($dead_leads*100)/$total_leads;
    
            $poorfit_leads = $this->count_poorfit_leads();
            $poorfit_leads_avg = ($poorfit_leads*100)/$total_leads;
        }else{
            $won_leads = $this->count_won_leads();
            $won_leads_avg = '0';
    
            $pending_leads = $this->count_pending_leads();
            $pending_leads_avg = '0';
    
            $dead_leads = $this->count_dead_leads();
            $dead_leads_avg = '0';
    
            $poorfit_leads = $this->count_poorfit_leads();
            $poorfit_leads_avg = '0';           
        }

        $monthly_leads_recap = $this->monthly_leads_recap();
        $m_total_leads = json_encode($monthly_leads_recap['total_leads']);
        $m_pending_leads = json_encode($monthly_leads_recap['pending_leads']);
        $m_won_leads = json_encode($monthly_leads_recap['won_leads']);
        $m_dead_leads = json_encode($monthly_leads_recap['dead_leads']);
        $m_poorfit_leads = json_encode($monthly_leads_recap['poorfit_leads']);

        // oldest year = The year when first lead is created.
        $first_lead = Lead::select('created_at')->oldest()->first();
        if($first_lead != null){
            $oldest_year = $first_lead->created_at->format('Y');
        }else{
            $oldest_year = '0';
        }

        $now = Carbon::now();
        $thisYear = $now->isoFormat('YYYY');

        $monthly_leads_avg =  json_encode($this->monthly_leads_avg());
        return view('crm.home', compact([
            'route_active',
            'total_revenue',
            'pending_leads',
            'pending_leads_avg',
            'won_leads',
            'won_leads_avg',
            'dead_leads',
            'dead_leads_avg',
            'poorfit_leads',
            'poorfit_leads_avg',
            'total_leads',
            
            'monthly_leads_recap',
            'm_total_leads',
            'm_pending_leads',
            'm_won_leads',
            'm_dead_leads',
            'm_poorfit_leads',

            'thisYear',
            'oldest_year',

            'monthly_leads_avg'
        ]));
    }


    public function monthly_leads_avg(){
        $now = Carbon::now();
        $thisYear = $now->isoFormat('YYYY');

        $user = Auth::user();
        $user_id = $user->id;
        $total_leads = [];
        $won_leads = [];
        $monthly_leads_avg = [];
        // Total leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $total_leads = $query->count();
            $query = $query->where('lead_status_id','=','1');
            $won_leads = $query->count();
            if($total_leads != 0){
                $avg_leads = ($won_leads*100)/$total_leads;
                array_push($monthly_leads_avg, $avg_leads);
            }else{
                array_push($monthly_leads_avg, 0);
            }
        }
        return $monthly_leads_avg;
    }

    public function monthly_leads_recap(){
        $now = Carbon::now();
        $thisYear = $now->isoFormat('YYYY');

        $user = Auth::user();
        $user_id = $user->id;
        
        $monthly_leads_recap = [];
        
        $total_leads = [];
        $pending_leads = [];
        $won_leads = [];
        $dead_leads = [];
        $poorfit_leads = [];

        // Total leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $leads = $query->count();
            array_push($total_leads, $leads);
        }

        // Pending Leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            $query = $query->where('lead_status_id','!=','1');
            $query = $query->where(['is_dead'=>'no','is_poor_fit'=>'no']);
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $leads = $query->count();
            array_push($pending_leads, $leads);
        }

        // Won Leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            $query = $query->where('lead_status_id','=','1');
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $leads = $query->count();
            array_push($won_leads, $leads);
        }

        // Dead Leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            $query = $query->where('lead_status_id','!=','1');
            $query = $query->where(['is_dead'=>'yes']);
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $leads = $query->count();
            array_push($dead_leads, $leads);
        }

        // Poorfit Leads
        for ($i=1; $i <= 12; $i++) { 
            $query = Lead::query($user_id);
            $query = $query->whereYear('created_at', $thisYear);
            $query = $query->whereMonth('created_at', '=', $i);
            $query = $query->where('lead_status_id','!=','1');
            $query = $query->where(['is_poor_fit'=>'yes']);
            if ($user->role->name != 'admin') {
                $query = $query->where(['owner_id'=>$user_id]);
            }
            $leads = $query->count();
            array_push($poorfit_leads, $leads);
        }
        
        $monthly_leads_recap = [
            'total_leads'=>$total_leads,
            'won_leads'=>$won_leads,
            'poorfit_leads'=>$poorfit_leads,
            'pending_leads'=>$pending_leads,
            'dead_leads'=>$dead_leads
        ];
        return $monthly_leads_recap;
    }

    public function count_poorfit_leads(){
        $user = Auth::user();
        $user_id = $user->id;
        $query = Lead::query($user_id);
        $query = $query->where('lead_status_id','!=','1');
        $query = $query->where(['is_poor_fit'=>'yes']);
        if ($user->role->name != 'admin') {
            $query = $query->where(['owner_id'=>$user_id]);
        }
        $poor_leads = $query->count();
        return $poor_leads;
    }

    public function count_dead_leads(){
        $user = Auth::user();
        $user_id = $user->id;
        $query = Lead::query($user_id);
        $query = $query->where('lead_status_id','!=','1');
        $query = $query->where(['is_dead'=>'yes']);
        if ($user->role->name != 'admin') {
            $query = $query->where(['owner_id'=>$user_id]);
        }
        $dead_leads = $query->count();
        return $dead_leads;
    }

    public function count_total_leads(){
        $user = Auth::user();
        $user_id = $user->id;
        $query = Lead::query($user_id);
        if ($user->role->name != 'admin') {
            $query = $query->where(['owner_id'=>$user_id]);
        }
        $total_leads = $query->count();            
        return $total_leads;        
    }

    public function count_pending_leads(){
        $user = Auth::user();
        $user_id = $user->id;
        $query = Lead::query($user_id);
        $query = $query->where('lead_status_id','!=','1');
        $query = $query->where(['is_dead'=>'no','is_poor_fit'=>'no']);
        if ($user->role->name != 'admin') {
            $query = $query->where(['owner_id'=>$user_id]);
        }
        $pending_leads = $query->count();            
        return $pending_leads;
    }

    public function count_won_leads(){
        $user = Auth::user();

        $user = Auth::user();
        $user_id = $user->id;
        $query = Lead::query($user_id);
        $query = $query->where('lead_status_id','=','1');
        if ($user->role->name != 'admin') {
            $query = $query->where(['owner_id'=>$user_id]);
        }
        $won_leads = $query->count();
        return $won_leads;
    }
}
