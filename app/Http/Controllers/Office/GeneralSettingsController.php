<?php

namespace App\Http\Controllers\Office;

use App\Models\SMTP;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsController extends Controller
{
    public function index()
    {
        $route_active = 'general_setting';
        $logo = SingleRowData::where('field_name','logo_file')->first();
        $company_name = SingleRowData::where('field_name','company_name')->first();
        $company_address = SingleRowData::where('field_name','company_address')->first();
        $company_city = SingleRowData::where('field_name','company_city')->first();
        $company_state = SingleRowData::where('field_name','company_state')->first();
        $company_country = SingleRowData::where('field_name','company_country')->first();
        $company_zip = SingleRowData::where('field_name','company_zip')->first();
        $company_phone = SingleRowData::where('field_name','company_phone')->first();
        $company_email = SingleRowData::where('field_name','company_email')->first();
        $terms = SingleRowData::where('field_name','terms')->first();
        return view('crm.office.general_setting', compact([
            'route_active', 
            'logo',
            'company_name',
            'company_address',
            'company_city',
            'company_state',
            'company_country',
            'company_zip',
            'company_phone',
            'company_email',
            'terms'
        ]));
    }

    // Company Logo 
    public function store(Request $request)
    {
        if($request->has('logo_file')){
        // if you want to delete the image from the directory
           $extension = ".".$request->logo_file->getClientOriginalExtension();
           $name = basename($request->logo_file->getClientOriginalName(), $extension).time();
           $name = $name.$extension;
           $path = $request->logo_file->storeAs('adminfiles',$name,'public');
         }
         if($extension == '.png' || $extension == '.jpg' || $extension == '.jpeg' || $extension == '.gif' || $extension == '.PNG' || $extension == '.JPG' || $extension == '.JPEG' || $extension == '.GIF') {
             $extension = 'image';
         }
         $logo = SingleRowData::create([
             'field_name'=>'logo_file',
             'field_type'=>'file',
             'field_value'=>$name,
        ]);

        if($logo->save()){
            $notification = array(
                'message' => 'File uploaded successfully!',
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

    // Terms and Conditions Create
    public function terms(Request $request)
    {
        $validated = $request->validate([
            'terms'=>'required',
        ]);
        if($validated){
            $terms = SingleRowData::create([
                'field_name'=>'terms',
                'field_type'=>'text',
                'field_value'=>$request->terms,
           ]);
           if($terms){
               $notification = array(
                   'message' => 'Terms added successfully!',
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
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);            
        }
    }

    // Terms and Conditions Update
    public function termsUpdate(SingleRowData $terms, Request $request)
    {
        $validated = $request->validate([
            'terms'=>'required',
        ]);
        if($validated){
            $terms->field_value = $request->terms;
            if($terms->save()){
                $notification = array(
                    'message' => 'Terms updated successfully!',
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
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);            
        }
    }

    // Company Address Store
    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'company_name'=>'required'
        ]);
        $company_name = SingleRowData::create([
             'field_name'=>'company_name',
             'field_type'=>'text',
             'field_value'=>$request->company_name,
        ]);
        SingleRowData::create([
            'field_name'=>'company_address',
            'field_type'=>'text',
            'field_value'=>$request->company_address,
       ]);
       SingleRowData::create([
        'field_name'=>'company_city',
        'field_type'=>'text',
        'field_value'=>$request->company_city,
        ]);
        SingleRowData::create([
            'field_name'=>'company_state',
            'field_type'=>'text',
            'field_value'=>$request->company_state,
        ]);
        SingleRowData::create([
            'field_name'=>'company_country',
            'field_type'=>'text',
            'field_value'=>$request->company_country,
        ]);
        SingleRowData::create([
            'field_name'=>'company_zip',
            'field_type'=>'text',
            'field_value'=>$request->company_zip,
        ]);
        SingleRowData::create([
            'field_name'=>'company_phone',
            'field_type'=>'text',
            'field_value'=>$request->company_phone,
        ]);
        SingleRowData::create([
            'field_name'=>'company_email',
            'field_type'=>'text',
            'field_value'=>$request->company_email,
        ]);

        if($validated){
            $notification = array(
                'message' => 'Company details saved successfully!',
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

    // Company Address Update
    public function updateDetails(Request $request, $company_name)
    {
        $validated = $request->validate([
            'company_name'=>'required'
        ]);

        $company_name = SingleRowData::where('field_name','company_name')->first();
        $company_name->field_value = $request->company_name;
        $company_name->save();

        $company_address = SingleRowData::where('field_name','company_address')->first();
        $company_address->field_value = $request->company_address;
        $company_address->save();
        
        $company_city = SingleRowData::where('field_name','company_city')->first();
        $company_city->field_value = $request->company_city;
        $company_city->save();
        
        $company_state = SingleRowData::where('field_name','company_state')->first();
        $company_state->field_value = $request->company_state;
        $company_state->save();
        
        $company_country = SingleRowData::where('field_name','company_country')->first();
        $company_country->field_value = $request->company_country;
        $company_country->save();
        
        $company_zip = SingleRowData::where('field_name','company_zip')->first();
        $company_zip->field_value = $request->company_zip;
        $company_zip->save();
        
        $company_phone = SingleRowData::where('field_name','company_phone')->first();
        $company_phone->field_value = $request->company_phone;
        $company_phone->save();
        
        $company_email = SingleRowData::where('field_name','company_email')->first();
        $company_email->field_value = $request->company_email;
        $company_email->save();

        if($validated){
            $notification = array(
                'message' => 'Company details updated successfully!',
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

    public function update(Request $request,  $logo)
    {
        if($request->has('logo_file')){
            // if you want to delete the image from the directory
           Storage::delete('adminfiles'.$request->logo_file);
           $extension = ".".$request->logo_file->getClientOriginalExtension();
           $name = basename($request->logo_file->getClientOriginalName(), $extension).time();
           $name = $name.$extension;
           $path = $request->logo_file->storeAs('adminfiles',$name,'public');
         }
         if($extension == '.png' || $extension == '.jpg' || $extension == '.jpeg' || $extension == '.gif' || $extension == '.PNG' || $extension == '.JPG' || $extension == '.JPEG' || $extension == '.GIF') {
             $extension = 'image';
         }
        $logo = SingleRowData::find($logo);

        $logo->field_value = $name;
        
        if($logo->save()){
            $notification = array(
                'message' => 'File uploaded successfully!',
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

}
