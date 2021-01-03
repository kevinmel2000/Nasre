<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Mail\TaskMail;
use App\Models\Currency;
use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Jobs\Tasks\StaffEmailJob;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $route_active = 'task';
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $user = Auth::user();
        if ($user->role_id != '1') {
            $tasks = Task::where('owner_id',$user->id)->orwhere('created_by_id',$user->id)->orderby('id','desc')->get();
        }else{
            $tasks = Task::orderby('id','desc')->get();
        }
        
        // This start_date_js array is to prevent inline js and to remove onclick from the blade file.
        $start_date_js = [];
        $update_relation_js = [];
        $full_day_js = [];
        $repeat_task_js = [];
        $start_time_js = [];
        $end_time_js = [];
        $billable_js = [];
        foreach ($tasks as $task) {
            $start_date_js[$task->id] = "onclick=dateChange($task->id)";
            $update_relation_js[$task->id] = "onchange=update_relation($task->id)";
            $full_day_js[$task->id] = "onchange=is_all_day_modal($task->id)";
            $repeat_task_js[$task->id] = "onchange=repeat_task_modal($task->id)";
            $start_time_js[$task->id] = "onchange=startTimeChange($task->id)";
            $end_time_js[$task->id] = "onchange=endTimeChange($task->id)";
            $billable_js[$task->id] = "onchange=billable_modal($task->id)";
        }
        $task_ids = response()->json($tasks->modelKeys());
        $customers= Customer::orderby('id','desc')->get();
        $leads= Lead::orderby('id','desc')->get();

        return view('crm.task.index', 
        compact([
            'route_active', 
            'tasks', 
            'salesperson',
            'customers',
            'leads',
            'task_ids',
            'start_date_js',
            'update_relation_js',
            'full_day_js',
            'repeat_task_js',
            'start_time_js',
            'end_time_js',
            'billable_js',
        ]));
    }

    public function create()
    {
        $route_active = 'taskCreate';
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        return view('crm.task.create', compact(['route_active','salesperson']));  
    }

    public function getLeads(){
        $leads= Lead::orderby('id','desc')->get();
        return response()->json([
            'message'=>'success',
            'leads'=>$leads
        ]);
    }

    public function getCustomers(){
        $customers= Customer::orderby('id','desc')->get();
        return response()->json([
            'message'=>'success',
            'customers'=>$customers,
        ]);
    }

    public function store(Request $request)
    {
        if($request->relation == 'Lead'){
            $lead = Lead::where(['id'=>$request->lead_customer_id])->first();
            if($lead->leadStatus->name == 'Won'){
                $notification = array(
                    'message' => "You can't add task to this lead! This is already a customer.",
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }
        $validator = $request->validate([
            'description'=>'required',
            'start_date'=>'required',
            'relation'=>'required'
        ]);
        if($validator){
            $user = Auth::user();
            $task = Task::create([
                'description'=>$request->description,
                'type'=>$request->type,
                'status'=>$request->status,
                'relation'=>$request->relation,
                'customer_id'=>($request->relation == 'Customer') ? $request->lead_customer_id : NULL,
                'lead_id'=>($request->relation == 'Lead') ? $request->lead_customer_id : NULL,
                'owner_id'=>$request->owner_id,
                'priority'=>$request->priority,
                'start_date'=>$request->start_date,
                'repeat_task'=>($request->repeat_task == 'yes') ? 'yes' : 'no',
                'is_all_day'=>($request->is_all_day == 'yes') ? 'yes' : 'no',
                'start_time'=>$request->start_time,
                'end_time'=>$request->end_time,
                'billable'=>($request->billable == 'yes') ? 'yes' : 'no',
                'bill_amount'=>$request->bill_amount,
                'send_notifications'=>($request->send_notifications == 'yes') ? 'yes' : 'no',
                'created_by_id'=>$user->id
            ]);

            if ($request->repeat_task == 'yes') {
                $task->repeat_every = $request->repeat_every;
                $task->repeat_day_month = $request->repeat_day_month;
                $task->end_date = $request->end_date;
                $task->save();
            }    
            if ($request->send_email != null) {
                return $this->mailToStaff($task);
            }

            $notification = array(
                'message' => 'Task submitted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function mailToStaff(Task $task){
        $currency = Currency::where(['is_base_currency'=>'yes'])->first();
        StaffEmailJob::dispatch($task, $currency);
        $notification = array(
            'message' => 'Mail sent successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function update(Request $request, Task $task)
    {   
        $validator = $request->validate([
            'description'=>'required',
            'start_date'=>'required',
            'relation'=>'required'
        ]);
        if($validator){

            $task->description = $request->description;
            $task->type = $request->type;
            $task->status = $request->status;
            $task->relation = $request->relation;
            $task->customer_id = ($request->relation == 'Customer') ? $request->lead_customer_id : NULL;
            $task->lead_id = ($request->relation == 'Lead') ? $request->lead_customer_id : NULL;
            $task->owner_id = $request->owner_id;
            $task->priority = $request->priority;
            $task->start_date = $request->start_date;
            $task->start_time = $request->start_time;
            $task->end_time = $request->end_time;
            $task->repeat_task = ($request->repeat_task == 'yes') ? 'yes' : 'no';
            $task->is_all_day = ($request->is_all_day == 'yes') ? 'yes' : 'no';
            $task->billable = ($request->billable == 'yes') ? 'yes' : 'no';
            $task->bill_amount = $request->bill_amount;
            $task->save();
            if ($request->repeat_task == 'yes') {
                $task->send_notifications = ($request->send_notifications == 'yes') ? 'yes' : 'no';
                $task->repeat_every = $request->repeat_every;
                $task->repeat_day_month = $request->repeat_day_month;
                $task->end_date = $request->end_date;
                $task->save();
            }else{
                $task->send_notifications = 'no';
                $task->repeat_every = 'day';
                $task->repeat_day_month = '';
                $task->end_date = '';
                $task->save(); 
            }    

            $notification = array(
                'message' => 'Task updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(Task $task)
    {
        if ($task->delete()) {
            $notification = array(
                'message' => 'Task deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);  
        }else{
            $notification = array(
                'message' => 'Please try again or Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);  
        }
    }
}
