<?php

namespace Database\Seeders;

use App\Models\TearmCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TearmConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TearmCondition::create([
            'price' => 'Above prices are EX our works, Kachigam Daman',
            'tax' => 'GST @18%, will be applicable',
            'delivery' => '12 to 14 weeks from receipt of confirm order with Advance.',
            'payment' => '40% advance & 60% at the time of Delivery against Performa Invoice',
            'packing' => 'Extra at actual.',
            'forwarding' => 'Extra at actual.',
            'validity' => '30 days',
            'commissioning_charges' => 'Customer should provide food & accommodation & to & fro ticket Charges and local transportation. If commission is carried more than 2 Days, then the Customer has to pay the charges of Rs. 3,500.00 per day.',
            'guarantee' => 'One calendar year from date of dispatch, if any manufacturing Defects. No Guarantee for Bought out Items as they are purchase from Standard make',
            'cancellation_of_order' => 'Orders once placed will not be subsequently cancelled for any Reason whatsoever. In the case of orders being cancelled, the entire Amount of the advance will be forfeited',
            'judiciary' => 'Subject to Daman Judiciary only',
            'not_in_our_scope_of_supply' => 'Civil Works Pipe and Pipe line works, Cabling Works, Installation of machine',
        ]);
    }
}
