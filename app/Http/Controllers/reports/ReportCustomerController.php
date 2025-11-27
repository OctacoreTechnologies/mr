<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class ReportCustomerController extends Controller
{
    public function customerReport(Request $request){
        $customers=Customer::query();

        if($request->has('location_type') && $request->location_type!=''){
          $customers->whereIn('location_type',(array)$request->location_type);
        }

        if($request->has('region') && $request->region!=''){
           $customers->whereIn('region',(array)$request->region);
        }
        
        if($request->has('city') && $request->city!=''){
          $customers->whereIn('city',(array)$request->city);
        }
       if($request->has('area') && $request->area!=''){
          $customers->whereIn('area',(array)$request->area);
        }

        if($request->has('state') && $request->state!=''){
             $customers->whereIn('state',(array)$request->state);
        }

        
        if($request->has('continents') && $request->continents!=''){
             $customers->whereIn('continents',(array)$request->continents);
        }

        if($request->has('country') && $request->country!=''){
             $customers->whereIn('country',(array)$request->country);
        }

        if($request->has('status') && $request->status!=''){
             $customers->whereIn('status',(array)$request->status);
        }

        if($request->has('followed_by') && $request->followed_by!=''){
             $customers->whereIn('followed_by',(array)$request->followed_by);
        }

        $customers=$customers->get();

       return response()->view('reports.customers.report',[
            'customers'=>$customers,
            'users'=>User::all(),
            'states'=>State::all(),
            'regions'=>Customer::select('region')->distinct()->pluck('region'),
            'cities'=>Customer::select('city')->distinct()->pluck('city'),
            'areas'=>Customer::select('area')->distinct()->pluck('area'),
            // 'customers'=>Customer::all(),
        ]);

        

    }
}
