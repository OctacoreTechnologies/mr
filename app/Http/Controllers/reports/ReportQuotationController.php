<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Machine;
use App\Models\MachineType;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;

class ReportQuotationController extends Controller
{
    public function quotationReport(Request $request){
        $quotations = Quotation::query();
        $machines=Machine::all();
        if($request->has('reference_no') && $request->reference_no!=''){
           $quotations->where('reference_no',$request->reference_no);
        }
        if($request->has('status') && $request->status!=''){
           $quotations->whereIn('status',$request->status);
        }

        if ($request->has('machine_type') && !empty($request->machine_type)) {
            $machineTypeId = $request->machine_type;
        
            $quotations->whereHas('machine', function ($query) use ($machineTypeId) {
                $query->where('machine_type_id', $machineTypeId);
            });
        }

    

        if($request->has('machine_id') && !empty($request->machine_id)){
            $quotations->whereIn('machine_id',(array) $request->machine_id);
        }

        if($request->has('customers') && !empty($request->customers)){
            $quotations->whereIn('customer_id',(array) $request->customers);
        }

       if ($request->has('due_date') && $request->due_date != '') {
           $today = now();

        if ($request->due_date == 'today') {
            $quotations->whereDate('date', $today->format('Y-m-d'));
        } elseif ($request->due_date == 'this_week') {
            $quotations->whereBetween('date', [$today->startOfWeek()->toDate(), $today->endOfWeek()->toDate()]);
            // return $today->endOfWeek(); 
        } elseif ($request->due_date == 'this_month') {
            $quotations->whereMonth('date', $today->month);
        } elseif ($request->due_date == 'this_year') {
            $quotations->whereYear('date', $today->year);
        } elseif ($request->due_date == 'custom') {
            if ($request->has('from_date') && $request->has('to_date')) {
                $quotations->whereBetween('date', [$request->from_date, $request->to_date]);
            }
        }
      }

       if ($request->has('assigned_user') && !empty($request->assigned_user)) {
          $quotations->whereIn('followed_by', $request->assigned_user);
       }

       $quotations = $quotations->get();

        return response()->view('reports.quotations.report',[
            'quotations'=>$quotations,
            'machines'=>$machines,
            'users'=>User::all(),
            'customers'=>Customer::all(),
            'machineTypes'=>MachineType::all(),
        ]);
    }
}
