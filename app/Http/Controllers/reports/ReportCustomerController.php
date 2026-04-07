<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class ReportCustomerController extends Controller
{
     public function customerReport(Request $request)
     {
          $customers = Customer::query()->where('type', 'customer');

          // ── Helper: valid array filter ──
          // $request->filled() does NOT work for arrays, so we check manually
          // A filter is "active" only if it's present AND has at least one non-empty value

          $location_type = array_filter((array) $request->input('location_type', []));
          $region        = array_filter((array) $request->input('region', []));
          $city          = array_filter((array) $request->input('city', []));
          $area          = array_filter((array) $request->input('area', []));
          $state         = array_filter((array) $request->input('state', []));
          $continents    = array_filter((array) $request->input('continents', []));
          $country       = array_filter((array) $request->input('country', []));
          $status        = array_filter((array) $request->input('status', []));
          $followed_by   = array_filter((array) $request->input('followed_by', []));
          $due_date      = $request->input('due_date');
          $from_date     = $request->input('from_date');
          $to_date       = $request->input('to_date');

          // ── Apply filters ──

          if (!empty($location_type)) {
               $customers->whereIn('location_type', $location_type);
          }

          if (!empty($region)) {
               $customers->whereIn('region', $region);
          }

          if (!empty($city)) {
               $customers->whereIn('city', $city);
          }

          if (!empty($area)) {
               $customers->whereIn('area', $area);
          }

          if (!empty($state)) {
               // state[] sends IDs — join with states table to filter by state_id
               $customers->whereIn('state', $state);
               // If your column is named 'state' (not state_id), use:
               // $customers->whereIn('state', $state);
          }

          if (!empty($continents)) {
               $customers->whereIn('continents', $continents);
          }

          if (!empty($country)) {
               $customers->whereIn('country', $country);
          }

          if (!empty($status)) {
               $customers->whereIn('customer_status', $status);
          }

          if (!empty($followed_by)) {
               $customers->whereIn('followed_by', $followed_by);
          }

          // ── Date filter ──
          if ($due_date) {
               switch ($due_date) {
                    case 'today':
                         $customers->whereDate('created_at', today());
                         break;
                    case 'this_week':
                         $customers->whereBetween('created_at', [
                              now()->startOfWeek(),
                              now()->endOfWeek(),
                         ]);
                         break;
                    case 'this_month':
                         $customers->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year);
                         break;
                    case 'this_year':
                         $customers->whereYear('created_at', now()->year);
                         break;
                    case 'custom':
                         if ($from_date) {
                              $customers->whereDate('created_at', '>=', $from_date);
                         }
                         if ($to_date) {
                              $customers->whereDate('created_at', '<=', $to_date);
                         }
                         break;
               }
          }

          return response()->view('reports.customers.report', [
               'customers'  => $customers->get(),
               'users'      => User::all(),
               'states'     => State::all(),
               'regions'    => Customer::select('region')->whereNotNull('region')->distinct()->pluck('region'),
               'cities'     => Customer::select('city')->whereNotNull('city')->distinct()->pluck('city'),
               'areas'      => Customer::select('area')->whereNotNull('area')->distinct()->pluck('area'),
          ]);
     }
}
