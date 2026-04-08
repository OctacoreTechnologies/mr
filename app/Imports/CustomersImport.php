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
            $row['region'] = null;

        }
        return new Customer([
            'location_type'                 => $row['location_type']??null,
            'continent'                     =>  $row['continent'] ??null,
            'country'                       => $row['country']??null,
            'region'                        => $row['region']??null,
            'state'                         => $row['state']??null,
            'city'                          => $row['city']??null,
            'area'                          => $row['area']??null,
            'pincode'                       => $row['pincode']??null,
            'company_name'                  => $row['company_name']??null,
            'address_line_1'                => $row['address_line_1']??null,
            'address_line_2'                => $row['address_line_2']??null,
            'contact_person_1_name'         => $row['contact_person_1_name']??null,
            'contact_person_1_designation'  => $row['contact_person_1_designation']??null,
            'contact_person_1_email'        => $row['contact_person_1_email']??null,
            'contact_person_1_contact'      => $row['contact_person_1_contact']??null,
            'contact_person_2_name'         => $row['contact_person_2_name']??null,
            'contact_person_2_designation'  => $row['contact_person_2_designation']??null,
            'contact_person_2_contact'      => $row['contact_person_2_contact']??null,
            'contact_person_2_email'        => $row['contact_person_2_email']??null,
            'contact_person_3_name'         => $row['contact_person_3_name']??null,
            'contact_person_3_designation'  => $row['contact_person_3_designation']??null,
            'contact_person_3_contact'      => $row['contact_person_3_contact']??null,
            'contact_person_3_email'        => $row['contact_person_3_email']??null,
            'contact_person_4_name'         => $row['contact_person_4_name']??null,
            'contact_person_4_designation'  => $row['contact_person_4_designation']??null,
            'contact_person_4_contact'      => $row['contact_person_4_contact']??null,
            'contact_person_4_email'        => $row['contact_person_4_email']??null,
            'contact_person_5_name'         => $row['contact_person_5_name']??null,
            'contact_person_5_designation'  => $row['contact_person_5_designation']??null,
            'contact_person_5_contact'      => $row['contact_person_5_contact']??null,
            'contact_person_5_email'        => $row['contact_person_5_email']??null,
            'contact_person_6_name'         => $row['contact_person_6_name']??null,
            'contact_person_6_designation'  => $row['contact_person_6_designation']??null,
            'contact_person_6_contact'      => $row['contact_person_6_contact']??null,
            'contact_person_6_email'        => $row['contact_person_6_email']??null,
            'gst'                           => $row['gst']??null,
            'remark'                        => $row['remark']??null,
            'status'                        => $row['status']??null,
            'contact_no'                    => $row['contact_no']??null,
            'email'                         => $row['email']??null,
            'ref_no'                        => $row['ref_no']??null,
            'kind_attn'                     => $row['kind_attn']??null,
            'user_id'                       => $row['user_id']??null,
            'followed_by'                   => $row['followed_by']??null,
        ]);
    }
}

