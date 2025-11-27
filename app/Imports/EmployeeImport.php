<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class EmployeeImport implements ToModel, WithStartRow, WithHeadingRow, WithSkipDuplicates
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'name' =>$row['name'],
            'email' =>$row['email'],
            'mobile' =>$row['mobile'],
            'doj' =>$row['doj'],
            'status' =>$row['status'],
            'type' =>$row['type'],
            'salary' =>$row['salary']
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
    
}
