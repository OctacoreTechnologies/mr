<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SaleOrder;
use App\Models\User;
use Illuminate\Http\Request;
use PDO;

class ReportSaleOrderController extends Controller
{
    public function saleOrderReport(Request $request)
    {


        $saleOrder = SaleOrder::query();

        if ($request->has('reference_no') && $request->reference_no != '') {
            $reference_no=$request->reference_no;
            $saleOrder->whereHas('quotation', function ($query) use ($reference_no) {
                $query->where('reference_no', $reference_no);
            });
        }


        if ($request->has('customers') && $request->customers != "") {
            $customerId = $request->customers;

            $saleOrder->whereHas('quotation', function ($query) use ($customerId) {
                $query->whereIn('customer_id', $customerId);
            });
        }

        if ($request->has('status') && $request->status != "") {
            $saleOrder->whereIn('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status != "") {
            $saleOrder->whereIn('payment_status', $request->payment_status);
        }

        if ($request->has('followed_by') && $request->followed_by != "") {
            $saleOrder->whereIn('followed_by', $request->followed_by);
        }

        if ($request->has('due_date') && $request->due_date != '') {
            $today = now();

            if ($request->due_date == 'today') {
                $saleOrder->whereDate('delivery_date', $today->format('Y-m-d'));
            } elseif ($request->due_date == 'this_week') {
                $saleOrder->whereBetween('delivery_date', [$today->startOfWeek()->toDate(), $today->endOfWeek()->toDate()]);
                // return $today->endOfWeek(); 
            } elseif ($request->due_date == 'this_month') {
                $saleOrder->whereMonth('delivery_date', $today->month);
            } elseif ($request->due_date == 'this_year') {
                $saleOrder->whereYear('delivery_date', $today->year);
            } elseif ($request->due_date == 'custom') {
                if ($request->has('from_date') && $request->has('to_date')) {
                    $saleOrder->whereBetween('delivery_date', [$request->from_date, $request->to_date]);
                }
            }
        }

        $saleOrders = $saleOrder->get();

        return response()->view('sale_orders.report', [
            'saleOrders' => $saleOrders,
            'customers' => Customer::all(),
            'users' => User::all(),
        ]);

    }
}
