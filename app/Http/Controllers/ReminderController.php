<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reminder;
use App\Mail\ReminderMail;
use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use App\Jobs\Reminders\StaffEmailJob;

class ReminderController extends Controller
{

    public function index()
    {
        $route_active = 'reminder';
        $users = User::where('role_id','!=','1')->where('status','active')->get(); // all users except admin
        $user = Auth::user();
        if ($user->role_id != '1') {
            $reminders = Reminder::where('user_id',$user->id)->orwhere('created_by_id', $user->id)->orderby('id','desc')->get();
        }else{
            $reminders = Reminder::orderby('id','desc')->get();
        }
        $reminder_ids = response()->json($reminders->modelKeys());
        $customers= Customer::orderby('id','desc')->get();
        $leads= Lead::orderby('id','desc')->get();
 
        return view('crm.reminder.index', compact(['route_active', 'reminders', 'users','customers','leads','reminder_ids']));
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
                    'message' => "You can't add reminder to this lead!",
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }
        $validator = $request->validate([
            'description'=>'required',
            'user_id'=>'required',
        ]);
        $user = Auth::user();
        if($validator){
            $reminder = Reminder::create([
                'description'=>$request->description,
                'user_id'=>$request->user_id,
                'date'=>$request->date,
                'time'=>$request->time,
                'send_email'=>($request->send_email == 'yes') ? 'yes' : 'no',
                'relation'=>$request->relation,
                'customer_id'=>($request->relation == 'Customer') ? $request->lead_customer_id : NULL,
                'lead_id'=>($request->relation == 'Lead') ? $request->lead_customer_id : NULL,
                'created_by_id'=>$user->id
            ]);
            if($request->send_email != null){
                StaffEmailJob::dispatch($reminder);
                $notification = array(
                    'message' => 'Reminder submitted and emailed successfully!',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            }    
            $notification = array(
                'message' => 'Reminder submitted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }
    public function mailToStaff(Reminder $reminder){
        StaffEmailJob::dispatch($reminder)->delay(now()->addMinutes(1));
        $notification = array(
            'message' => 'Mail added in the queue successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function update(Request $request, Reminder $reminder)
    {
        $validator = $request->validate([
            'description'=>'required',
            'user_id'=>'required',
        ]);
        if($validator){

            $reminder->description = $request->description;
            $reminder->user_id = $request->user_id;
            $reminder->date = $request->date;
            $reminder->time = $request->time;
            $reminder->send_email = ($request->send_email == 'yes') ? 'yes' : 'no';
            $reminder->relation = $request->relation;
            $reminder->customer_id = ($request->relation == 'Customer') ? $request->lead_customer_id : NULL;
            $reminder->lead_id = ($request->relation == 'Lead') ? $request->lead_customer_id : NULL;
            $reminder->save();

            $notification = array(
                'message' => 'Reminder updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function updateNotification(Request $request, Reminder $reminder)
    {
            $reminder->send_email = ($request->send_email == 'yes') ? 'yes' : 'no';
            $reminder->save();
            $notification = array(
                'message' => 'Reminder updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
    }

    public function destroy(Reminder $reminder)
    {
        if ($reminder->delete()) {
            $notification = array(
                'message' => 'Reminder deleted successfully!',
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
