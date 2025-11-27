<?php

namespace App\Http\Controllers;

use App\Exports\SupplierExport;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\State;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SupplierImport;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers=Supplier::get(['id','name','contact_person_name','mobile','email','gst','city','state']);
        return view('supplier',['suppliers'=>$suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        Supplier::create([
            'name'=>$request->name,
            'contact_person_name'=>$request->contact_person_name,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'gst'=>$request->gst,
            'address_line_1'=>$request->address_line_1,
            'address_line_2'=>$request->address_line_2,
            'city'=>$request->city,
            'state'=>$request->state,
            'pincode'=>$request->pincode,
            'remarks'=>$request->remarks,
            'status'=>$request->status ?? 'active'
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $states=State::all();
        return view('supplier_edit',['supplier'=>$supplier,'states'=>$states]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        
        $supplier->name=$request->name;
        $supplier->contact_person_name=$request->contact_person_name;
        $supplier->mobile=$request->mobile;
        $supplier->email=$request->email;
        $supplier->gst=$request->gst;
        $supplier->address_line_1=$request->address_line_1;
        $supplier->address_line_2=$request->address_line_2;
        $supplier->city=$request->city;
        $supplier->state=$request->state;
        $supplier->pincode=$request->pincode;
        $supplier->remarks=$request->remarks;
        $supplier->status=$request->status;
        $supplier->save();
        return back();
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back();
    }


    public function export() 
    {
        return Excel::download(new SupplierExport, 'supplier.xlsx');
    }

    public function import(Request $request) 
    {
        if ($request->hasFile('supplier')) {
            $file = $request->file('supplier');
        }
        // dd($file);
        Excel::import(new SupplierImport, $file);
        return back()->with('success', 'All good!');
    }

    public function import_form(Request $request) 
    {
        return view('import_supplier');
    }

}
