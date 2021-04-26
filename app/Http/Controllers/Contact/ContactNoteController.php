<?php

namespace App\Http\Controllers\Contact;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Models\Customer\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $route_active = 'customer_note';
        $notes = Note::where(['customer_id'=>$customer->id])->orderby('id','desc')->get();
        $note_ids = response()->json($notes->modelKeys());
        return view('crm.customer.note', compact(['route_active', 'customer', 'notes','note_ids']));
    }

    /**
     * NOTE API Route - Store a newly created resource in storage.
     */
    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'note'=>'required'
        ]);
        $user = Auth::user();
        if($validated){
            $note = Note::create([
                'note'=> $request->note,
                'customer_id'=>$request->customer_id
            ]);
            $notification = array(
                'user'=>$user->name,
                'message' => 'Note added successfully!',
                'status' => 'success',
                'note' => $note
            );
            return response()->json($notification);
        }else{
            return response()->json($validated->errors);
        }
    }





    /**
     * NOTE API Route Remove the specified resource from storage.
     */
    public function destroyNote(Note $note)
    {
        if($note->delete()){
            $notification = array(
                'message' => 'Note deleted successfully!',
                'status' => 'success',
            );
            return response()->json($notification);
        }
        else{
            $notification = array(
                'message' => 'Please try again!',
                'status' => 'error',
            );
            return response()->json($notification);
        }
    }
}
