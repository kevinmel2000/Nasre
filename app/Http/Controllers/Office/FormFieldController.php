<?php

namespace App\Http\Controllers\Office;

use App\Models\FormField;
use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class FormFieldController extends Controller
{
    public function index()
    {
        $formfields = FormField::get();
        $formfield_ids = response()->json($formfields->modelKeys());
        $route_active = 'Fields';
        $lead_fields = [
            'submit',
            'note',
            'first_name',
            'last_name',
            'company_name',
            'website',
            'email',
            'phone',
            'whatsapp',
            'city',
            'state',
            'country',
            'zip',
            'facebook',
            'twitter',
            'linkedin',
            'youtube',
            'skype',
            'instagram'
        ];
        return view('crm.office.formfield.index', compact([
            'route_active', 
            'formfields',
            'formfield_ids',
            'lead_fields'
        ]));
    }

    // API Route
    public function getFormField($id){
        $formfield = FormField::where(['id'=>$id])->first();
        return response()->json([
            'id'=>$id,
            'field'=>$formfield,
            'message'=>'success'
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required|unique:form_fields',
            'type'=>'required',
        ]);
        if ($validator) {
            $formfield = FormField::create([
                'name'=>$request->name,
                'type'=>$request->type,
                'placeholder'=>$request->placeholder,
                'helptext'=>$request->helptext,
                'limit'=>$request->limit,
                'cssclass'=>$request->cssclass,
                'required'=>($request->required == 'on') ? 'yes' : 'no'
            ]);
            if ($formfield) {
                $notification = array(
                    'message' => 'Field created successfully!',
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

    public function update(Request $request, FormField $formfield)
    {
        $validator = $request->validate([
            'name'=>'required | unique:form_fields,name,'.$formfield->id,
            'type'=>'required',

        ]);
       
        if($validator){
            $formfield->name = $request->name;
            $formfield->type = $request->type;
            $formfield->placeholder = $request->placeholder;
            $formfield->helptext = $request->helptext;
            $formfield->limit = $request->limit;
            $formfield->cssclass = $request->cssclass;
            $formfield->required = ($request->required == 'on') ? 'yes' : 'no';
            $formfield->save();

            $notification = array(
                'message' => 'Field updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(FormField $formfield)
    {
        if($formfield->delete()){
            $notification = array(
                'message' => 'Form field deleted successfully!',
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
