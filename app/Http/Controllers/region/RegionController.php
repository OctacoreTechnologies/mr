<?php

namespace App\Http\Controllers\region;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getStates($region_id)
    {
        
        $states = State::where('region_id', $region_id)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($states);
    }
}
