<?php

namespace App\Imports;

use App\Models\Note;
use App\Models\Address\Address;
use App\Models\Contact\Contact;
use App\Models\SocialMediaField;
use App\Models\Customer\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements 
    ToCollection, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError
{
    use Importable, SkipsErrors;
    private $rows = 0;
    public function collection(Collection $collection)
    {
        
        foreach ($collection as $row) 
        {
            ++$this->rows;
            // dd($row['username']);
            // Make a new customer
            $customer = Customer::create([
                'username'=> $row['username'],
                'password'=> bcrypt($row['password']),
                'customer_type'=> $row['customer_type'],
                'prospect_status'=> $row['prospect_status'],
                "owner_id"=>$row['owner_id'],
                'vat_number'=> $row['vat_number'],
                'website'=> $row['website'],
                'industry_id'=> $row['industry_id'],
                'company_name'=> $row['company_name'],
            ]); 

            $contact = Contact::create([
                "is_primary"=>'yes',       // Primary contact is created along with customer ID.
                "customer_id"=>$customer->id,
                "title_id"=> $row['title_id'],
                'first_name'=> $row['first_name'],
                'last_name'=> $row['last_name'],
        
                'email'=> $row['email'],
                'phone'=> $row['phone'],
                'whatsapp'=> $row['whatsapp'],

                'language_id'=> $row['language_id'],
                'decision_maker'=> ($row['decision_maker'] == 'yes')? 'yes': 'no',
                'personal_id'=> $row['personal_id'],
    
                'gender'=> $row['gender'],
            ]);
    


            $note = Note::create([
                "customer_id"=>$customer->id,
                'owner_id'=>$row['owner_id'], // Note added By - Note Owner
            ]);  

            $address = Address::create([
                "customer_id"=>$customer->id,
                "address_line_1" => $row['address_line_1'],
                "address_line_2" => $row['address_line_2'],
              
                "zip" => $row['zip'],
        
            ]);

            $SocialMediaField = SocialMediaField::create([
                "customer_id"=>$customer->id,
            ]);

        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
       return [
        '*.username' => ['required', 'unique:customers,username'],
        '*.email' => ['required','email' ,'unique:contacts,email'],
        '*.title_id' => ['required'],
        '*.last_name' => ['required'],
        '*.password' => ['required'],
       ]; 
    }
}