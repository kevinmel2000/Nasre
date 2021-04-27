<?php

namespace App\Imports;

use App\Models\Note;
use App\Models\Leads\Lead;
use App\Models\Address\Address;
use App\Models\SocialMediaField;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LeadsImport implements 
    ToCollection, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError
{
    use Importable, SkipsErrors;
    private $rows = 0;
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            ++$this->rows;
            $lead = Lead::create([
                'user_id' => $row['user_id'],
                'title_id' => $row['title_id'],
                'language_id'=> $row['language_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'company_name' => $row['company_name'],
                'website' => $row['website'],
                'email' => $row['email'],
                'fax' => $row['fax'],
                'phone' => $row['phone'],
                'whatsapp' => $row['whatsapp'],
                'prospect_status' => $row['prospect_status'],
                'owner_id' => $row['owner_id'],
                'last_owner_id' => $row['last_owner_id'],
                'industry_id' => $row['industry_id'],
                'lead_source_id' => $row['lead_source_id'],
                'lead_status_id' => $row['lead_status_id'],
                'lead_temprature' => $row['lead_temprature'],
                'is_dead' => $row['is_dead'],
                'is_poor_fit' => $row['is_poor_fit'],
            ]);

            Note::create([
                "lead_id"=>$lead->id,
            ]); 
            Address::create([
                "lead_id"=>$lead->id,
            ]);
            SocialMediaField::create([
                "lead_id"=>$lead->id,
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
        '*.last_name' => ['required', 'unique:leads,last_name'],
        '*.title_id' => ['required'],
        '*.lead_source_id' => ['required'],
        '*.lead_status_id' => ['required'],
       ]; 
    }
}
