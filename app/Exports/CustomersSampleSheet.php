<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;

class CustomersSampleSheet implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'location_type','continent','country','region','state','city','area','pincode',
            'company_name','address_line_1','address_line_2',
            'contact_person_1_name','contact_person_1_designation','contact_person_1_email','contact_person_1_contact',
            'contact_person_2_name','contact_person_2_designation','contact_person_2_contact','contact_person_2_email',
            'contact_person_3_name','contact_person_3_designation','contact_person_3_contact','contact_person_3_email',
            'contact_person_4_name','contact_person_4_designation','contact_person_4_contact','contact_person_4_email',
            'contact_person_5_name','contact_person_5_designation','contact_person_5_contact','contact_person_5_email',
            'contact_person_6_name','contact_person_6_designation','contact_person_6_contact','contact_person_6_email',
            'gst','remark','status','contact_no','email','ref_no','kind_attn','user_id','followed_by'
        ];
    }

    public function array(): array
    {
        return [
            [
                'domstic','','','West','Gujarat','Surat','Adajan','395009',
                'ABC Pvt Ltd','Adajan Road','Near Star Bazar',
                'Rahul Sharma','Manager','rahul@abc.com','9876543210',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                '24ABCDE1234F1Z5','Regular Client','active','9876543210','info@abc.com','REF001','Mr Rahul',1,2
            ],
            [
                'international','Asia','UAE','Middle East','Dubai','Dubai Marina','Marina','000000',
                'XYZ LLC','Marina Tower','Office 1201',
                'Ali Khan','Director','ali@xyz.com','9988776655',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                '','','','',
                'UAE123456','Important Client','active','9988776655','contact@xyz.com','REF002','Mr Ali',2,3
            ],
        ];
    }
}