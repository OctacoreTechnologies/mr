<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\State;

class RegionStateSeeder extends Seeder
{
    public function run(): void
    {
        // Create Regions
        $north = Region::firstOrCreate(['name' => 'North']);
        $south = Region::firstOrCreate(['name' => 'South']);
        $east  = Region::firstOrCreate(['name' => 'East']);
        $west  = Region::firstOrCreate(['name' => 'West']);
        $central = Region::firstOrCreate(['name' => 'Central']);
        $northEast = Region::firstOrCreate(['name' => 'North-East']);

        // NORTH
        State::whereIn('name', [
            'Delhi',
            'Punjab',
            'Haryana',
            'Uttar Pradesh',
            'Himachal Pradesh',
            'Uttarakhand',
            'Jammu and Kashmir',
            'Chandigarh',
            'Ladakh'
        ])->update(['region_id' => $north->id]);

        // SOUTH
        State::whereIn('name', [
            'Tamil Nadu',
            'Kerala',
            'Karnataka',
            'Andhra Pradesh',
            'Telangana',
            'Puducherry',
            'Lakshadweep'
        ])->update(['region_id' => $south->id]);

        // EAST
        State::whereIn('name', [
            'West Bengal',
            'Bihar',
            'Odisha',
            'Jharkhand',
            'Andaman and Nicobar Islands'
        ])->update(['region_id' => $east->id]);

        // WEST
        State::whereIn('name', [
            'Maharashtra',
            'Gujarat',
            'Rajasthan',
            'Goa',
            'Dadra and Nagar Haveli and Daman and Diu'
        ])->update(['region_id' => $west->id]);

        // CENTRAL
        State::whereIn('name', [
            'Madhya Pradesh',
            'Chhattisgarh'
        ])->update(['region_id' => $central->id]);

        // NORTH-EAST
        State::whereIn('name', [
            'Assam',
            'Arunachal Pradesh',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Tripura',
            'Sikkim'
        ])->update(['region_id' => $northEast->id]);
    }
}
