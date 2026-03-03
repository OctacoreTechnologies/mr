<?php

namespace Database\Seeders;

use App\Models\BankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       BankDetail::create([
            'company_name' => 'M. R. Engineers',
            'bank_name' => ' HDFC Bank',
            'account_number' => '50200029265243',
            'ifsc_code' => 'HDFC0000170',
            'branch_name' => 'Chala, Vapi',
        ]);
    }
}
