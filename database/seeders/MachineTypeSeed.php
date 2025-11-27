<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machineTypes=[
            ['name'=>'Machine'],
            ['name'=>'Part'],
            ['name'=>'Service'],
        ];
        DB::table('machine_types')->insert($machineTypes);
    }
}
