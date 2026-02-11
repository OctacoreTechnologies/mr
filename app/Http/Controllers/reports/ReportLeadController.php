<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class ReportLeadController extends Controller
{
    public function leadReport(Request $request){
        $leads=Customer::query();

        if($request->has('lead_source') && $request->lead_source!=''){
           $leads->whereIn('lead_source',(array)$request->lead_source);
        }

       if ($request->has('due_date') && $request->due_date != '') {
           $today = now();

        if ($request->due_date == 'today') {
            $leads->whereDate('created_at', $today->format('Y-m-d'));
        } elseif ($request->due_date == 'this_week') {
            $leads->whereBetween('created_at', [$today->startOfWeek(), $today->endOfWeek()]);
        } elseif ($request->due_date == 'this_month') {
            $leads->whereMonth('created_at', $today->month);
        } elseif ($request->due_date == 'this_year') {
            $leads->whereYear('created_at', $today->year);
        } elseif ($request->due_date == 'custom') {
            if ($request->has('from_date') && $request->has('to_date')) {
                $leads->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
        }
      }
       if ($request->has('lead_source') && !empty($request->lead_source)) {
        $leads->whereIn('lead_source', (array)$request->lead_source);
       }

       if ($request->has('assigned_user') && !empty($request->assigned_user)) {
           $leads->whereIn('followed_by', (array) $request->assigned_user);
       }

       $leads = $leads->get();

        return response()->view('reports.leads.report',[
            'leads'=>$leads,
            'users'=>User::all(),
            // 'customers'=>Customer::all(),
        ]);

        
    }
}
