<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Imports\CustomersImport;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('user')->get();
        return response()->view('customers.index', [
            "customers" => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::all();
        $users = User::all();
        $countries = Country::all();
        return response()->view('customers.create', [
            'states' => $states,
            'users' => $users,
            'countries' => $countries,
            'regions' => Customer::select('region')->distinct()->pluck('region')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
        $customer = Customer::create($data);

        // Redirect based on submitted type (customer vs lead)
        $type = $request->input('type', 'customer');
        if ($type === 'customer') {
            session()->flash('success', 'Customer created successfully');
            return response()->redirectToRoute('customer.index');
        }

        // if type is 'lead' or anything else, redirect to lead index
        session()->flash('success', 'Lead created successfully');
        return response()->redirectToRoute('lead.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with(['followedBy'])->findOrFail($id);
        // return $customer;
        return response()->view('customers.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return response()->view('customers.edit', [
            'customer' => $customer,
            'states' => State::all(),
            'users' => User::all(),
            'countries' => Country::all(),
            'regions' => Customer::select('region')->distinct()->pluck('region')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerRequest $request, string $id)
    {

        $customer = Customer::findOrFail($id);
        $customer->update($request->validated());
        // Redirect based on submitted type (customer vs lead)
        $type = $request->input('type', 'customer');
        if ($type === 'customer') {
            session()->flash('success', 'Customer updated successfully');
            return response()->redirectToRoute('customer.index');
        }

        // if type is 'lead' or anything else, redirect to lead index
        session()->flash('success', 'Lead updated successfully');
        return response()->redirectToRoute('lead.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->redirectToRoute('customers.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new CustomersImport, $request->file('file'));

        return back()->with('success', 'Customer data imported successfully!');
    }

    public function customerDetail($customerId)
    {
        $customer = Customer::select('contact_person_2_email', 'contact_person_3_email', 'contact_person_4_email', 'contact_person_5_email', 'contact_person_6_email')->findOrFail($customerId);
        return response()->json(
            [
                'status' => true,
                'customer' => $customer,
            ]
        );
    }
}
