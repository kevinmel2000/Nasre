<?php

namespace App\Http\Controllers\Lead;

use App\Models\Leads\LeadSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeadSourceController extends Controller
{

    // ANCHOR GET  getleadSources API ROUTE
    public function getleadSources(){
        $leadsource = LeadSource::select(['id','name'])->orderby('id','desc')->get();
        return response()->json(['leadsource'=>$leadsource]);
    }

    // ANCHOR POST storeSource API ROUTE
    public function storeSource(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required'
        ]);
        if(!$validated){
            return response()->json($validated->errors);
        }else{
           
            $Source = LeadSource::where('name',$request->name)->first();
            if($Source){
                // if Source not matched
                $notification = array(
                    'message' => 'This source has already been added, Try some other!',
                    'status' => 'error'
                );
                return response()->json($notification);
            }else{
                $new_source = LeadSource::create(['name'=> $request->name]);
                $notification = array(
                    'message' => 'Source added successfully!',
                    'status' => 'success',
                    'new_source' => $new_source
                );
                return response()->json($notification);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lead_sources = LeadSource::all();
        $route_active = 'lead_source';
        $source_ids = response()->json($lead_sources->modelKeys());
        return view('crm.lead.source', compact(['route_active', 'lead_sources','source_ids']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required'
        ]);
        if($validated){
            $source = LeadSource::where('name',$request->name)->first();
            if($source){
                // if status not matched
                $notification = array(
                    'message' => 'This source is already registered!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }else{
                LeadSource::create(['name'=> $request->name]);
                $notification = array(
                    'message' => 'Source added successfully!',
                    'alert-type' => 'success'
                );

                if($request->return_to != null && $request->return_to == 'lead'){
                    return redirect(url('lead/source'))->with($notification);
                }
                return redirect(url('lead/source'))->with($notification);
            }

        }else{
            // if not validated
            return back()->withErrors($validated)->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leads\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadSource $leadSource)
    {
        $leadSource->name = $request->name;
        $leadSource->save();

        $notification = [
            'alert-type'=>'success',
            'message'=>'Sourec updated successfully!'
        ];
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leads\LeadSource  $leadSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadSource $leadSource)
    {
        if($leadSource->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'Source deleted successfully!'
            ];
            return back()->with($notification);
        }
    }
}
