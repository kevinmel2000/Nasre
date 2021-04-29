<?php

use App\Models\Note;
use App\Models\Leads\Lead;
use App\Models\Address\Address;
use Illuminate\Database\Seeder;
use App\Models\SocialMediaField;

class LeadSeeder extends Seeder
{
    public function run()
    {
        $leads = factory(Lead::class, 100)->create();
        foreach ($leads as $lead) {
            factory(Note::class, 1)->create([
                'lead_id'=>$lead->id
            ]);
            factory(SocialMediaField::class, 1)->create([
                'lead_id'=>$lead->id
            ]);
            factory(Address::class, 1)->create([
                'lead_id'=>$lead->id
            ]);
        }
    }
}
