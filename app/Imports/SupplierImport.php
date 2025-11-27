<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class SupplierImport implements ToModel, WithStartRow, WithHeadingRow, WithSkipDuplicates
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'name'=>$row['name'],
            'contact_person_name'=>$row['contact_person_name'],
            'mobile'=>$row['mobile'],
            'email'=>$row['email'],
            'gst'=>$row['gst'],
            'address_line_1'=>$row['address_line_1'],
            'address_line_2'=>$row['address_line_2'],
            'city'=>$row['city'],
            'state'=>$row['state'],
            'pincode'=>$row['pincode'],
            'remarks'=>$row['remarks'],
            'status'=>$row['status']
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
    
}
