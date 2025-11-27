<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CImport;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers=Customer::get();
        // $customers=Customer::get(['id', 'name']);
        $states=State::all();
        return view('customer',['customers'=>$customers,'states'=>$states]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
       Customer::create($request->validated());

        return back()->with('success','Customer Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $states=State::all();
        return view('customer_show',['states'=>$states,'customer'=>$customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $states=State::all();
        return view('customer_edit',['customer'=>$customer,'states'=>$states]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {

        $customer->location_type=$request->location_type;
        $customer->country=$request->country;
        $customer->region=$request->region;
        $customer->state=$request->state;
        $customer->city=$request->city;
        $customer->area=$request->area;
        $customer->pincode=$request->pincode;
        $customer->company_name=$request->company_name;
        $customer->address_line_1=$request->address_line_1;
        $customer->address_line_2=$request->address_line_2;
        $customer->contact_person_1_name=$request->contact_person_1_name;
        $customer->contact_person_1_designation=$request->contact_person_1_designation;
        $customer->contact_person_1_contact=$request->contact_person_1_contact;
        $customer->contact_person_1_email=$request->contact_person_1_email;
        $customer->contact_person_2_name=$request->contact_person_2_name;
        $customer->contact_person_2_designation=$request->contact_person_2_designation;
        $customer->contact_person_2_contact=$request->contact_person_2_contact;
        $customer->contact_person_2_email=$request->contact_person_2_email;
        $customer->gst=$request->gst;
        $customer->remarks=$request->remarks;
        $customer->status=$request->status;


        // $customer->name=$request->name;
        // $customer->contact_person_name=$request->contact_person_name;
        // $customer->mobile=$request->mobile;
        // $customer->email=$request->email;
        // $customer->gst=$request->gst;
        // $customer->address_line_1=$request->address_line_1;
        // $customer->address_line_2=$request->address_line_2;
        // $customer->city=$request->city;
        // $customer->state=$request->state;
        // $customer->pincode=$request->pincode;
        // $customer->first_follow_up_date=$request->first_follow_up_date;
        // $customer->whatsapp_number=$request->whatsapp_number;
        // $customer->remarks=$request->remarks;
        // $customer->status=$request->status;

        $customer->save();

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back();
    }

    public function export() 
    {
        return Excel::download(new CustomerExport, 'customer.xlsx');
    }

    public function import(Request $request) 
    {
        if ($request->hasFile('customer')) {
            $file = $request->file('customer');
        }
        // dd($file);
        Excel::import(new CImport, $file);
        return back()->with('success', 'All good!');
    }

    public function import_form(Request $request) 
    {
        return view('import_customer');
    }

}
