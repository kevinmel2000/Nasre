<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $route_active = 'media';
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        $user = Auth::user();
        if ($user->role_id != '1') {
            $medias = Media::where('uploaded_by',$user->id)->orderby('id','desc')->get();
        }else{
            $medias = Media::get();
        }
        return view('crm.media.index', compact(['route_active', 'medias', 'salesperson']));
    }

    public function getLeads(){
        $leads= Lead::get();
        return response()->json([
            'message'=>'success',
            'leads'=>$leads
        ]);
    }

    public function getCustomers(){
        $customers= Customer::get();
        $contacts = [];
        $customers= Customer::get();
        foreach ($customers as $customer) {
            array_push($contacts, $customer->contact);
        }
        return response()->json([
            'message'=>'success',
            'customers'=>$customers,
            'contacts'=>$contacts
        ]);
    }

    public function store(Request $request)
    {
        if($request->relation == 'Lead'){
            $lead = Lead::where(['id'=>$request->lead_customer_id])->first();
            if($lead->leadStatus->name == 'Won'){
                $notification = array(
                    'message' => "You can't add media to this lead!",
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }
        $current_user = Auth::user();
        if($request->has('file_name')){
            // if you want to delete the image from the directory
           $extension = ".".$request->file_name->getClientOriginalExtension();
           $name = basename($request->file_name->getClientOriginalName(), $extension).time();
           $name = $name.$extension;
           $path = $request->file_name->storeAs('mediafiles',$name,'public');
         }
         if($extension == '.png' || $extension == '.jpg' || $extension == '.jpeg' || $extension == '.gif' || $extension == '.PNG' || $extension == '.JPG' || $extension == '.JPEG' || $extension == '.GIF') {
             $extension = 'image';
         }
         $media = Media::create([
            'file_name' => $name,
            'file_path' => $path,
            'file_type' => $extension,
            'uploaded_by' => $current_user->id,
            'relation'=>$request->relation,
            'customer_id'=>($request->relation == 'Customer') ? $request->lead_customer_id : NULL,
            'lead_id'=>($request->relation == 'Lead') ? $request->lead_customer_id : NULL,
        ]);

        if($media->save()){
            $notification = array(
                'message' => 'Media File uploaded successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function destroy(Media $media)
    {
        Storage::disk('public')->delete($media->file_path);
        if ($media->delete()) {
            $notification = array(
                'message' => 'File record deleted successfully!',
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
