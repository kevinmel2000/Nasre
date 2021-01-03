<?php

namespace App\Http\Controllers\Contact;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use App\Models\Media;
use App\Models\Invoice;
use App\Models\Estimate;
use App\Models\Industry;
use App\Models\Language;
use App\Models\Proposal;
use App\Models\Reminder;
use App\Models\Leads\Lead;
use Illuminate\Http\Request;
use App\Models\SingleRowData;
use App\Models\Address\Address;
use App\Models\Contact\Contact;
use App\Imports\CustomersImport;
use App\Models\SocialMediaField;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Contact\ContactTitle;
use Illuminate\Support\Facades\Auth;
use App\Jobs\Customer\CustomerRegister;

class ContactController extends Controller
{

    /**
     *  GET - /customer/import
     *  
     *  @return blade file
     */
    public function import()
    {
        $languages = Language::all();
        $industries = Industry::all();
        $route_active = 'manage_contact';
        return view('crm.customer.customers_import', compact(['route_active', 'languages', 'industries']));
    }

    /**
     *  POST - /customer/import
     *  
     *  @param - customer fields
     *  
     *  @return - bulk import Customers
     */
    public function importStore(Request $request){
        $file = $request->file('file')->store('import');
        $import = new CustomersImport;
        $import->import($file);
        if(count($import->errors()) == 0){
            $notification = array(
                'message' => $import->getRowCount().' customers imported successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->withErrors($import->errors());
        }
    }

    public function index(){  
        $route_active = 'manage_contact';
        $customers = Customer::get();
        $customer_ids = response()->json($customers->modelKeys());
        return view('crm.customer.index', compact(['route_active', 'customers','customer_ids']));
    }

    public function create()
    {
        $route_active = 'add_contact';
        $contact_titles = ContactTitle::get();
        $countries = DB::table('countries')->get();
        $languages = DB::table('languages')->get();
        $industries = DB::table('industries')->get();
        return view('crm.customer.create', compact(['route_active', 'contact_titles', 'countries','languages','industries']));
    }

    public function leadToCustomer(Lead $lead, Request $request){
        $validator = $request->validate([
            'title_id' => 'required',
            'last_name' => 'required',
            'username' => 'required | unique:customers',
            'email' => 'required | email | unique:contacts',
            'password' => 'required'
        ]);
        if(!$validator){
            return back()->with($validator)->withInput();
        }

        // Make new contact with all the data from the lead and delete the lead data.
        $customer = Customer::create([
            'username'=>$request->username,
            'password'=>bcrypt($request->password),
            'industry_id'=>$lead->industry_id,
            'website'=>$lead->website,
            'company_name'=>$lead->company_name,
            'owner_id'=>$lead->owner_id,
            'success_timestamp'=>now()
        ]); 

        $contact  = Contact::create([
            "is_primary"=>'yes',       // Primary contact is created along with customer ID.
            'customer_id'=>$customer->id,
            'title_id'=>$lead->title_id,
            'first_name'=>$lead->first_name,
            'last_name'=>$lead->last_name,
            'email'=>$lead->email,
            'phone'=>$lead->phone,
            'language_id'=>$lead->language_id,
            'whatsapp'=>$lead->whatsapp,
        ]);
   
        $address = Address::where('id',$lead->address_id)->first(); 
        if(@$lead->address->lead_id != NULL){
            $lead->address->customer_id = $customer->id; 
            $lead->address->save();
        }

        $social_media_field = SocialMediaField::where('lead_id',$lead->id)->first(); 
        $social_media_field->customer_id = $customer->id; 
        $social_media_field->save();

        foreach ($lead->note as $note) {
            $note = Note::where(['id'=> $note->id])->first();
            $note->customer_id = $customer->id; 
            $note->save();
        }
        $proposals = Proposal::where(['lead_id'=>$lead->id])->get();
        foreach ($proposals as  $proposal) {
            $proposal->relation = 'Customer';    
            $proposal->customer_id = $customer->id; 
            $proposal->save();
        }
        $tasks = Task::where(['lead_id'=>$lead->id])->get();
        foreach ($tasks as  $task) {
            $task->relation = 'Customer'; 
            $task->customer_id = $customer->id; 
            $task->save();
        }
        $media = Media::where(['lead_id'=>$lead->id])->get();
        foreach ($media as  $media) {
            $media->relation = 'Customer';  
            $media->customer_id = $customer->id; 
            $media->save();
        }
        $reminers = Reminder::where(['lead_id'=>$lead->id])->get();
        foreach ($reminers as  $reminder) {
            $reminder->relation = 'Customer';  
            $reminder->customer_id = $customer->id; 
            $reminder->save();
        }

        $lead->lead_status_id = 1; // 1 is won status
        $lead->win_time = now(); // lead won time
        $lead->save();

        return $this->mailToClient($customer, $request->password);
        $notification = array(
            'message' => 'Lead converted into customer successfully!',
            'alert-type' => 'success'
        );
        return redirect(url('customer'))->with($notification);
    }

    public function check_user_id(Request $request){
        $customer = Customer::where(['username'=>$request->username])->first();
        if ($customer) {
            return response()->json([
                'customer'=>$customer,
                'status'=>'success',
                'message'=>'username_found'
            ]);
        }else{
            return response()->json([
                'status'=>'success',
                'message'=>'username_not_found'
            ]);
        }
    }     

    public function check_email_availability(Request $request){
        $check_email = Contact::where(['email'=>$request->email])->first();
        if ($check_email) {
            return response()->json([
                'status'=>'success',
                'message'=>'email_found'
            ]);
        }else{
            return response()->json([
                'status'=>'success',
                'message'=>'email_not_found'
            ]);
        }
    }

    public function getProposals(Customer $customer){
        $proposals = Proposal::where(['relation'=>'Customer','customer_id'=>$customer->id])->get();
        $route_active = 'customer_proposal';
        $proposal_ids = response()->json($proposals->modelKeys());
        return view('crm.customer.proposal', compact(['route_active', 'customer' ,'proposals','proposal_ids']));
    }

    public function getInvoices(Customer $customer){
        $invoices = Invoice::where(['customer_id'=>$customer->id])->get();
        $route_active = 'customer_invoice';
        $invoice_ids = response()->json($invoices->modelKeys());
        return view('crm.customer.invoice', compact(['route_active', 'customer' ,'invoices','invoice_ids']));
    }

    public function getEstimates(Customer $customer){
        $estimates = Estimate::where(['customer_id'=>$customer->id])->get();
        $estimate_ids = response()->json($estimates->modelKeys());
        $route_active = 'customer_estimate';
        return view('crm.customer.estimate', compact(['route_active', 'customer' ,'estimates','estimate_ids']));
    }

    public function getTasks(Customer $customer){
        $tasks = Task::where(['customer_id'=>$customer->id])->get();
        $task_ids = response()->json($tasks->modelKeys());
        $route_active = 'customer_task';
        $salesperson = User::where('role_id','!=','1')->where('role_id','3')->where('status','active')->get();
        return view('crm.customer.task', compact(['route_active', 'customer' ,'tasks','salesperson','task_ids']));
    }

    public function getMedia(Customer $customer){
        $media = Media::where(['customer_id'=>$customer->id])->get();
        $media_ids = response()->json($media->modelKeys());
        $route_active = 'customer_media';
        return view('crm.customer.media', compact(['route_active', 'customer' ,'media','media_ids']));
    }

    public function getReminder(Customer $customer){
        $reminders = Reminder::where(['customer_id'=>$customer->id])->get();
        $reminder_ids = response()->json($reminders->modelKeys());
        $route_active = 'customer_reminder';
        $users = User::where('role_id','!=','1')->where('status','active')->get(); // all users except admin
        return view('crm.customer.reminder', compact(['route_active', 'customer','users','reminders','reminder_ids']));
    }

    // Send Register welcome mail
    public function mailToClient(Customer $customer, $password=false){
        $company_details = [];
        $company_name = SingleRowData::where('field_name','company_name')->first();
        array_push($company_details, $company_name);
        $company_address = SingleRowData::where('field_name','company_address')->first();
        array_push($company_details, $company_address);
        $company_city = SingleRowData::where('field_name','company_city')->first();
        array_push($company_details, $company_city);
        $company_state = SingleRowData::where('field_name','company_state')->first();
        array_push($company_details, $company_state);
        $company_country = SingleRowData::where('field_name','company_country')->first();
        array_push($company_details, $company_country);
        $company_zip = SingleRowData::where('field_name','company_zip')->first();
        array_push($company_details, $company_zip);
        $company_phone = SingleRowData::where('field_name','company_phone')->first();
        array_push($company_details, $company_phone);
        $company_email = SingleRowData::where('field_name','company_email')->first();
        array_push($company_details, $company_email);
        CustomerRegister::dispatch($customer, $company_details, $password);
        $notification = array(
            'message' => 'Contact added and notified successfully!',
            'alert-type' => 'success'
        );
        return redirect(url('customer'))->with($notification);
    }

    // Store customer and related data
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title_id' => 'required',
            'last_name' => 'required',
            'username' => 'required | unique:customers',
            'email' => 'required | email | unique:contacts',
            'password' => 'required'
        ]);
        if(!$validator){
            return back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();

        // Make a new customer
        $customer = Customer::create([
            'username'=> $request->username,
            'password'=> bcrypt($request->password),
            'customer_type'=> $request->customer_type,
            'prospect_status'=> $request->prospect_status,
            "owner_id"=>$user->id,
            'vat_number'=> $request->vat_number,
            'website'=> $request->website,
            'industry_id'=> $request->industry_id,
            'company_name'=> $request->company_name,
        ]); 

        $contact = Contact::create([
            "is_primary"=>'yes',       // Primary contact is created along with customer ID.
            "customer_id"=>$customer->id,
            "title_id"=> $request->title_id,
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
      
            'email'=> $request->email,
            'phone'=> $request->phone,
            'whatsapp'=> $request->whatsapp,

            'language_id'=> $request->language_id,
            'decision_maker'=> ($request->decision_maker == 'yes')? 'yes': 'no',
            'personal_id'=> $request->personal_id,
 
            'birth_date'=> $request->birth_date,
            'gender'=> $request->gender,
        ]);
  


        $note = Note::create([
            "customer_id"=>$customer->id,
            'owner_id'=>$user->id, // Note added By - Note Owner
            'note'=> $request->note
        ]);  

        $address = Address::create([
            "customer_id"=>$customer->id,
            "address_line_1" => $request->address_line_1,
            "address_line_2" => $request->address_line_2,
            "country_id" => $request->country_id,
            "state_id" => $request->state_id,
            "city_id" => $request->city_id,
            "zip" => $request->zip,
            "phone_1" => $request->phone_1,
            "phone_2" => $request->phone_2,
            "email_1" => $request->email_1,
            "email_2" => $request->email_2,
            "is_billing_address" => ($request->is_billing_address == 'yes')?'yes': 'no',
            "is_shipping_address" => ($request->is_shipping_address == 'yes')?'yes': 'no',
        ]);

        $SocialMediaField = SocialMediaField::create([
            "customer_id"=>$customer->id,
            "linkedin" => $request->linkedin,
            "facebook" => $request->facebook,
            "twitter" => $request->twitter,
            "skype" => $request->skype,
            "instagram" => $request->instagram,
            "youtube" => $request->youtube,
            "tumblr" => $request->tumblr,
            "snapchat" => $request->snapchat,
            "reddit" => $request->reddit,
            "pinterest" => $request->pinterest,
            "telegram" => $request->telegram,
            "vimeo" => $request->vimeo,
            "patreon" => $request->patreon,
            "flickr" => $request->flickr,
            "discord" => $request->discord,
            "tiktok" => $request->tiktok,
            "vine" => $request->vine
        ]);
        if($contact){
            if ($request->send_email != null) {
                return $this->mailToClient($customer, $request->password);
            }
            $notification = array(
                'message' => 'Contact added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification)->withInput();
        }
    }

    // Store contact only
    public function storeContact(Request $request){
        {
            $validator = $request->validate([
                'title_id' => 'required',
                'last_name' => 'required',
                'email' => 'required | email | unique:contacts'
            ]);
            if(!$validator){
                return back()->withErrors($validator)->withInput();
            }
            $contact = Contact::create([
                "is_primary"=>'no',       // Primary contact is created along with customer ID.
                "customer_id"=>$request->customer_id,
                "title_id"=> $request->title_id,
                'first_name'=> $request->first_name,
                'last_name'=> $request->last_name,
          
                'email'=> $request->email,
                'phone'=> $request->phone,
                'whatsapp'=> $request->whatsapp,
    
                'language_id'=> $request->language_id,
                'decision_maker'=> ($request->decision_maker == 'yes')? 'yes': 'no',
                'personal_id'=> $request->personal_id,
     
                'birth_date'=> $request->birth_date,
                'gender'=> $request->gender,
            ]);

            if($contact){
                $notification = array(
                    'message' => 'Contact added successfully!',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            }else{
                $notification = array(
                    'message' => 'Please try again!',
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }        
    }

    public function updateContact(Request $request, Contact $contact){
        {
            $customer = Customer::where(['id'=>$contact->customer_id])->first();
            $validator = $request->validate([
                'title_id' => 'required',
                'last_name' => 'required',
                'username'=>'required | unique:customers,username,'.$customer->id,
                'email'=>'sometimes | email |unique:contacts,email,'.$contact->id,
            ]);
            if(!$validator){
                return back()->withErrors($validator)->withInput();
            }

            $contact->customer_id = $request->customer_id;
            $contact->title_id =  $request->title_id;
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->whatsapp = $request->whatsapp;
            $contact->language_id = $request->language_id;
            $contact->decision_maker = ($request->decision_maker == 'yes')? 'yes': 'no';
            $contact->personal_id = $request->personal_id;
            $contact->birth_date = $request->birth_date;
            $contact->gender = $request->gender;

            if($contact->save()){
                $notification = array(
                    'message' => 'Contact updated successfully!',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            }else{
                $notification = array(
                    'message' => 'Please try again!',
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }        
    }   

    public function makeContactPrimary(Request $request, Contact $contact){
        {
            $old_primary_contact = Contact::where(['is_primary'=>'yes'])->first();
            if($old_primary_contact->id == $contact->id){
                $notification = array(
                    'message' => 'You have to keep atleat one contact as primary!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);                
            }
            $old_primary_contact->is_primary = 'no';
            $old_primary_contact->save();
            $contact->is_primary = 'yes';
            if($contact->save()){
                $notification = array(
                    'message' => 'Contact updated successfully!',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            }else{
                $notification = array(
                    'message' => 'Please try again!',
                    'alert-type' => 'error'
                );
                return back()->with($notification)->withInput();
            }
        }        
    }   
    
    public function show(Customer $customer)
    {
        $route_active = 'show_contact';
        $contact_titles = ContactTitle::get();
        $countries = DB::table('countries')->get();

        if ($customer->address == NULL) {
            $states = [];
            $cities = [];
        }else{
            $states = DB::table('states')->where(['country_id'=>$customer->address->country_id])->get();
            $cities = DB::table('cities')->where(['state_id'=>$customer->address->state_id])->get();
        }
 
        $languages = DB::table('languages')->get();
        $industries = DB::table('industries')->get();

        $address = Address::where(['customer_id'=>$customer->id])->first();
        $SocialMediaField = SocialMediaField::where(['customer_id'=>$customer->id])->first();
        $note = Note::where(['customer_id'=>$customer->id])->first();
        // if ( $note == null) {
        //     $note ='';
        // }
        return view('crm.customer.show', compact(['route_active', 'customer', 'contact_titles', 'countries', 'states', 'cities','languages','industries','address','SocialMediaField','note']));
    }

    public function update(Request $request, Customer $customer)
    {
        $contact = $customer->first_contact;
        if($request->page_name != NULL && $request->page_name == 'from_leadToCustomer'){
            // If update request is coming from leadToCustomer, then username is required, check for it.
            if($request->username == NULL){
                $notification = array(
                    'message' => 'Username is required!',
                    'alert-type' => 'error'
                );
                return redirect(url('/customer/show', $customer))->with($notification)->withInput();    
            }
        }
        $validator = $request->validate([
            'title_id'=>'required',
            'last_name'=>'required',
            'username'=>'required | unique:customers,username,'.$customer->id,
            'email'=>'sometimes | email |unique:contacts,email,'.$contact->id,
        ]);

        if(!$validator){
            return redirect(url('/customer/show', $customer))->withErrors($validator)->withInput();
        }
        $address = Address::where(['customer_id'=>$customer->id])->first();
        $SocialMediaField = SocialMediaField::where(['customer_id'=>$customer->id])->first();
        
        $customer->username = $request->username;
        // $contact->password = bcrypt($request->username);
        $customer->customer_type = $request->customer_type;
        $customer->prospect_status = $request->prospect_status;
        $customer->company_name = $request->company_name;
        $customer->website = $request->website;
        $customer->vat_number = $request->vat_number;
        $customer->industry_id = $request->industry_id;
        $customer->save();

        $note = Note::where(['customer_id'=>$customer->id])->first();
        if ($note == null) {
            $note = Note::create([
                'note'=>$request->note,
                'customer_id'=>$customer->id
            ]);
        }else{
            $note->note = $request->note;
            $note->save();
        }
       

        $contact->title_id = $request->title_id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;

        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->whatsapp = $request->whatsapp;
        $contact->language_id = $request->language_id;
        $contact->decision_maker = ($request->decision_maker == 'yes')?'yes':'no';
        $contact->personal_id = $request->personal_id;
        $contact->birth_date = $request->birth_date;
        $contact->gender = $request->gender;
        $contact->updated_at = now();
        $contact->save();
  

        $address->address_line_1 = $request->address_line_1;
        $address->address_line_2 = $request->address_line_2;
        $address->country_id = $request->country_id;
        $address->state_id = $request->state_id;
        $address->city_id = $request->city_id;
        $address->zip = $request->zip;
        $address->phone_1 = $request->phone_1;
        $address->phone_2 = $request->phone_2;
        $address->email_1 = $request->email_1;
        $address->email_2 = $request->email_2;
        $address->is_billing_address = ($request->is_billing_address == 'yes')?'yes': 'no';
        $address->is_shipping_address = ($request->is_shipping_address == 'yes')?'yes': 'no';
        $address->save();


        $SocialMediaField->linkedin = $request->linkedin;
        $SocialMediaField->facebook = $request->facebook;
        $SocialMediaField->twitter = $request->twitter;
        $SocialMediaField->skype = $request->skype;
        $SocialMediaField->instagram = $request->instagram;
        $SocialMediaField->youtube = $request->youtube;
        $SocialMediaField->tumblr = $request->tumblr;
        $SocialMediaField->snapchat = $request->snapchat;
        $SocialMediaField->reddit = $request->reddit;
        $SocialMediaField->pinterest = $request->pinterest;
        $SocialMediaField->telegram = $request->telegram;
        $SocialMediaField->vimeo = $request->vimeo;
        $SocialMediaField->patreon = $request->patreon;
        $SocialMediaField->flickr = $request->flickr;
        $SocialMediaField->discord = $request->discord;
        $SocialMediaField->tiktok = $request->tiktok;
        $SocialMediaField->vine = $request->vine;
        $SocialMediaField->save();
        // dd($request->page_name);
        if($customer->save()){
            $notification = array(
                'message' => 'Customer updated successfully!',
                'alert-type' => 'success'
            );
           
            if($request->page_name != NULL && $request->page_name == 'from_leadToCustomer'){
                return redirect(url('/customer/show', $customer))->with($notification)->withInput();
            }else{
                return back()->with($notification)->withInput();
            }
        }else{
            $notification = array(
                'message' => 'Please try again!',
                'alert-type' => 'error'
            );
            return redirect(url('/customer/show', $customer))->with($notification)->withInput();
        }

    }

    public function destroy(Customer $customer)
    {
        Address::where(['customer_id'=>$customer->id])->delete();
        SocialMediaField::where(['customer_id'=>$customer->id])->delete();

        foreach ($customer->contacts as $contact) {
            $contact->delete();
        }
        
        if($customer->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'Customer and his contacts deleted successfully!'
            ];
            return back()->with($notification);
        }
    }

    public function destroyContact(Contact $contact)
    {
        if($contact->is_primary == 'yes'){
            $notification = [
                'alert-type'=>'error',
                'message'=>'You can not delete primary contact, it is bound with the customer ID!'
            ];
            return back()->with($notification);            
        }
        elseif($contact->delete()){
            $notification = [
                'alert-type'=>'success',
                'message'=>'Contact deleted successfully!'
            ];
            return back()->with($notification);
        }
    }


        // API ROUTE - CONTACT STORE
    // public function store_api(Request $request)
    // {
    //     return response()->json([
    //         'request'=>$request->all()
    //     ]);
    //     $user = Auth::user();
    //     $validator = Validator::make($request->all(), [
    //         'title_id'          =>'required',
    //         'name'              =>'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['errors'=>$validator->errors()]);
    //     }else{
    //         $contact = Contact::create([
    //             'user_id'          => $user->id,
    //             "title_id"          => $request->title_id,
    //             'name'              => $request->name,
    //             'customer_type'     => $request->type,
    //             'prospect_status'   => $request->prospect_status,
    //             'company_name'      => $request->company_name,
    //             'email'     => $request->email,
    //             'phone'     => $request->phone,
    //             'whatsapp'          => $request->whatsapp,
    //             'website'           => $request->website,
    //             'vat_number'        => $request->vat_number,
    //         ]);
    //         if($contact){
    //             return response()->json([
    //                 'status'=>'success',
    //                 'message'=>'Contact added successfully!',
    //                 'contact'=>$contact->id 
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'status'=>'failed',
    //                 'message'=>'Please refresh the page and try again, or contact Admin!',
    //             ]);               
    //         }    
    //     }
    // }

    // API ROUTE - CONTACT UPDATE
    // public function update_api(Request $request, $id)
    // {
    //     $user = Auth::user();
    //     $contact = Contact::where(['id'=>$id])->first();
    //     $validator = Validator::make($request->all(), [
    //         'title_id'          =>'required',
    //         'name'              =>'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['errors'=>$validator->errors()]);
    //     }else{
    //         $contact->user_id = $user->id;
    //         $contact->title_id = $request->title_id;
    //         $contact->name = $request->name;
    //         $contact->customer_type = $request->customer_type;
    //         $contact->prospect_status = $request->prospect_status;
    //         $contact->company_name = $request->company_name;
    //         $contact->email = $request->email;
    //         $contact->phone = $request->phone;
    //         $contact->website = $request->website;
    //         $contact->vat_number = $request->vat_number;
    //         if($contact->save()){
    //             return response()->json([
    //                 'status'=>'success',
    //                 'message'=>'Contact Updated successfully!',
    //                 'contact'=>$contact->id 
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'status'=>'failed',
    //                 'message'=>'Please refresh the page and try again, or contact Admin!',
    //             ]);               
    //         }    
    //     }
    // }
}
