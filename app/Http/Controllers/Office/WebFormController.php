<?php

namespace App\Http\Controllers\Office;

use App\Models\FormField;
use Illuminate\Http\Request;
use App\Models\WebToLeadForm;
use App\Models\Leads\LeadSource;
use App\Http\Controllers\Controller;

class WebFormController extends Controller
{
    public function create()
    {
        $formfields = FormField::get();
        $route_active = 'Create Form';
        $token = md5(config('app.name').now());
        
        $addFields = [];
        foreach ($formfields as  $formfield) {
            $addFields[$formfield->id] = 'onclick="addField('.$formfield->id.')"';
        }

        $removeFields = [];
        foreach ($formfields as  $formfield) {
            $removeFields[$formfield->id] = 'onclick="removeField('.$formfield->id.')"';
        }

        $lead_sources = LeadSource::get();
        return view('crm.office.web_form.create', compact([
            'route_active', 
            'formfields',
            'token',
            'lead_sources',
            'addFields',
            'removeFields'
        ]));
    }

    public function getForm($token){
        $form = WebToLeadForm::where(['token'=>$token])->first();
        if($form == null){
            return abort(403, 'This page does not exists!');
        }
        return $form->formdata;
    }

    public function index()
    {
        $web_forms = WebToLeadForm::get();
        $webform_ids = response()->json($web_forms->modelKeys());
        $route_active = 'Web to Lead Form';
        return view('crm.office.web_form.index', compact([
            'route_active', 
            'web_forms',
            'webform_ids'
        ]));
    }

    // Company Logo 
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'=>'required',
            'returnurl'=>'required',
            'formdata'=>'required',
            'token'=>'required'
        ]);
        if ($validator) {
            $webToLeadForm = WebToLeadForm::create([
                'title'=>$request->title,
                'returnurl'=>$request->returnurl,
                'formdata'=>$request->formdata,
                'heading'=>$request->heading,
                'note'=>$request->note,
                'token'=>$request->token,
            ]);
            if ($webToLeadForm) {
                $notification = array(
                    'message' => 'Form created successfully!',
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
            return back()->with($validator);
        }
    }
  
    public function destroy(WebToLeadForm $web_form)
    {
        if($web_form->delete()){
            $notification = array(
                'message' => 'Web form deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);            
        }else{
            $notification = array(
                'message' => 'Please refresh the page and try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

}
