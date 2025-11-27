<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Quotation;
use App\Models\SaleOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
public function dashboard(){
    // Get the current year
    $currentYear = now()->year;

    // Calculate the start and end of the financial year
    // Financial Year runs from April to March
    $startDate = now()->month >= 4 ? Carbon::create($currentYear, 4, 1) : Carbon::create($currentYear - 1, 4, 1);
    $endDate = $startDate->copy()->addYear()->subDay();

    // Fetch quotations, leads, and customers based on created_at within the financial year
    $quotations = Quotation::whereBetween('created_at', [$startDate, $endDate])->get();
    $leads = Lead::whereBetween('created_at', [$startDate, $endDate])->get();
    $opportunities=Opportunity::whereBetween('created_at',[$startDate, $endDate])->get();
    $baseQuery = Customer::whereBetween('created_at', [$startDate, $endDate]);
    
    $leadCustomers = (clone $baseQuery)->where('status','lead')->get();
    $quotatedCustomers = (clone $baseQuery)->where('status','quoated')->get();
    $invoiceCustomers = (clone $baseQuery)->where('status','existing')->get();

        $customers = $baseQuery->get();
        $saleOrders = SaleOrder::whereBetween('created_at', [$startDate, $endDate]);

        // $users = User::withCount([
        //     'quotationFollows as draft_count' => function ($query) use ($startDate, $endDate) {
        //         $query->where('status', 'draft')
        //             ->whereBetween('date', [$startDate, $endDate]);
        //     },
        //     'quotationFollows as sent_count' => function ($query) use ($startDate, $endDate) {
        //         $query->where('status', 'sent')
        //             ->whereBetween('date', [$startDate, $endDate]);
        //     },
        //     'quotationFollows as accepted_count' => function ($query) use ($startDate, $endDate) {
        //         $query->where('status', 'accepted')
        //             ->whereBetween('date', [$startDate, $endDate]);
        //     },
        //     'quotationFollows as rejected_count' => function ($query) use ($startDate, $endDate) {
        //         $query->where('status', 'rejected')
        //             ->whereBetween('date', [$startDate, $endDate]);
        //     },
        // ])->get();
        $users = User::count();

        // return $users;


    // Return the dashboard view with the data
    return response()->view('dashboards.index', [
        'quotations' => $quotations,
        'leads' => $leads,
        'customers' => $customers,
        'totalCustomerLeads'=>$leadCustomers,
        'totalCustomerQuoted'=>$quotatedCustomers,
        'totalCustomerInvoiced'=>$invoiceCustomers,
        'saleOrders' => $saleOrders,
        'users' => $users,
        'opportunities'=>$opportunities,
        'financialYear' => $startDate->format('Y') . '-' . $endDate->format('y'),
    ]);
   }

   public function summary(){
    $users = User::with([
        'saleOrderFollows',
        'leadFollows',
        'quotationFollows',
    ])->get();

    return view('users.dashbord', compact('users'));
 }



}
