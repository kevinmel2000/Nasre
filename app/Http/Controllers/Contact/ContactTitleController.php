<?php
namespace App\Http\Controllers\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact\ContactTitle;

class ContactTitleController extends Controller
{
    // ANCHOR GET TITLE API ROUTE
    public function getContactTitles(){
        $contactTitle = ContactTitle::select(['id','name'])->orderby('id','desc')->get();
        return response()->json(['contactTitle'=>$contactTitle]);
    }
    // ANCHOR POST TITLE API ROUTE
    public function storeTitle(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required'
        ]);
        if(!$validated){
            return response()->json($validated->errors);
        }else{
           
            $title = ContactTitle::where('name',$request->name)->first();
            if($title){
                // if title not matched
                $notification = array(
                    'message' => 'This title has already been added, Try some other!',
                    'status' => 'error'
                );
                return response()->json($notification);
            }else{
                $new_title = ContactTitle::create(['name'=> $request->name]);
                $notification = array(
                    'message' => 'Title added successfully!',
                    'status' => 'success',
                    'new_title' => $new_title
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
        $contact_titles = ContactTitle::all();
        $title_ids = response()->json($contact_titles->modelKeys());
        $route_active = 'contact_title';
        return view('crm.customer.title', compact(['route_active', 'contact_titles','title_ids']));
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
            $title = ContactTitle::where('name',$request->name)->first();
            if($title){
                // if title not matched
                $notification = array(
                    'message' => 'This title is already registered!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }else{
                ContactTitle::create(['name'=> $request->name]);
                $notification = array(
                    'message' => 'Title added successfully!',
                    'alert-type' => 'success'
                );

                if($request->return_to != null && $request->return_to == 'contact'){
                    return redirect(url('contact/title'))->with($notification);
                }
                return redirect(url('contact/title'))->with($notification);
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
     * @param  \App\Models\Contact\ContactTitle  $contactTitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactTitle $contactTitle)
    {
        $contactTitle->name = $request->name;
        $contactTitle->save();

        $notification = [
            'alert-type'=>'success',
            'message'=>'Title updated successfully!'
        ];
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact\ContactTitle  $contactTitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactTitle $contactTitle)
    {
        if($contactTitle->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'Title deleted successfully!'
            ];
            return back()->with($notification);
        }
    }
}
