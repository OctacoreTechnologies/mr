<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if($row['location_type'] == 'domstic'){
            $row['country'] = 'india';
            $row['continent'] = 'asia';
        }
        return new Customer([
            'location_type'                 => $row['location_type'],
            'continent'                     =>  $row['continent'] ,
            'country'                       => $row['country'],
            'region'                        => $row['region'],
            'state'                         => $row['state'],
            'city'                          => $row['city'],
            'area'                          => $row['area'],
            'pincode'                       => $row['pincode'],
            'company_name'                  => $row['company_name'],
            'address_line_1'                => $row['address_line_1'],
            'address_line_2'                => $row['address_line_2'],
            'contact_person_1_name'         => $row['contact_person_1_name'],
            'contact_person_1_designation'  => $row['contact_person_1_designation'],
            'contact_person_1_email'        => $row['contact_person_1_email'],
            'contact_person_1_contact'      => $row['contact_person_1_contact'],
            'contact_person_2_name'         => $row['contact_person_2_name'],
            'contact_person_2_designation'  => $row['contact_person_2_designation'],
            'contact_person_2_contact'      => $row['contact_person_2_contact'],
            'contact_person_2_email'        => $row['contact_person_2_email'],
            'contact_person_3_name'         => $row['contact_person_3_name'],
            'contact_person_3_designation'  => $row['contact_person_3_designation'],
            'contact_person_3_contact'      => $row['contact_person_3_contact'],
            'contact_person_3_email'        => $row['contact_person_3_email'],
            'contact_person_4_name'         => $row['contact_person_4_name'],
            'contact_person_4_designation'  => $row['contact_person_4_designation'],
            'contact_person_4_contact'      => $row['contact_person_4_contact'],
            'contact_person_4_email'        => $row['contact_person_4_email'],
            'contact_person_5_name'         => $row['contact_person_5_name'],
            'contact_person_5_designation'  => $row['contact_person_5_designation'],
            'contact_person_5_contact'      => $row['contact_person_5_contact'],
            'contact_person_5_email'        => $row['contact_person_5_email'],
            'contact_person_6_name'         => $row['contact_person_6_name'],
            'contact_person_6_designation'  => $row['contact_person_6_designation'],
            'contact_person_6_contact'      => $row['contact_person_6_contact'],
            'contact_person_6_email'        => $row['contact_person_6_email'],
            'gst'                           => $row['gst'],
            'remark'                        => $row['remark'],
            'status'                        => $row['status'],
            'contact_no'                    => $row['contact_no'],
            'email'                         => $row['email'],
            'ref_no'                        => $row['ref_no'],
            'kind_attn'                     => $row['kind_attn'],
            'user_id'                       => $row['user_id'],
            'followed_by'                   => $row['followed_by'],
        ]);
    }
}

