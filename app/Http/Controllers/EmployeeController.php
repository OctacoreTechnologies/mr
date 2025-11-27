<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\State;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees=Employee::get(['id','name','email','type']);
        return view('employee',['employees'=>$employees]);
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
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'doj'=>$request->doj,
            'type'=>$request->type,
            'salary'=>$request->salary,
            'pincode'=>$request->pincode,
            'remarks'=>$request->remarks,
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employee_edit',['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {

            $employee->name=$request->name;
            $employee->email=$request->email;
            $employee->mobile=$request->mobile;
            $employee->doj=$request->doj;
            $employee->type=$request->type;
            $employee->salary=$request->salary;
            $employee->save();
            return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back();
    }


    public function export() 
    {
        return Excel::download(new EmployeeExport, 'employee.xlsx');
    }

    public function import(Request $request) 
    {
        if ($request->hasFile('employee')) {
            $file = $request->file('employee');
        }
        Excel::import(new EmployeeImport, $file);
        return back()->with('success', 'All good!');
    }

    public function import_form(Request $request) 
    {
        return view('import_employee');
    }


}
