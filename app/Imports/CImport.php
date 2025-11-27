<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class CImport implements ToModel, WithStartRow, WithHeadingRow,WithSkipDuplicates
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!empty($row['name']))
        {
            return new Customer([
                'name' =>$row['name'] ?? null ,
                'contact_person_name' =>$row['contact_person_name'] ?? null ,
                'mobile' =>$row['mobile'] ?? null ,
                'email' =>$row['email'] ?? null ,
                'gst' =>$row['gst'] ?? null ,
                'address_line_1' =>$row['address_line_1'] ?? null ,
                'address_line_2' =>$row['address_line_2'] ?? null ,
                'city' =>$row['city'] ?? null ,
                'state' =>$row['state'] ?? null ,
                'pincode' =>$row['pincode'] ?? null ,
                'first_follow_up_date' =>$row['first_follow_up_date'] ?? null,
                'remarks' =>$row['remarks'] ?? null,
                'whatsapp_number' =>$row['whatsapp_number'] ?? null,
                'status'=>'active'
            ]);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
