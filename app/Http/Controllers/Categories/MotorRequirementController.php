<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMotorRequirementRequest;
use App\Models\MototRequirement;
use Illuminate\Http\Request;

class MotorRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $motorRequirements=MototRequirement::orderByDesc('created_at')->get();
          return response()->view('categories.motor_requirement.index',compact('motorRequirements'));
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
    public function store(StoreMotorRequirementRequest $request)
    {
        $validated=$request->validated();
        MototRequirement::create($validated);
        session()->flash('success','Motore Requirement Added Successfully');
        return response()->redirectToRoute('motor-requirement.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $motorRequirement=MototRequirement::findOrFail($id);
        return response()->view('categories.motor_requirement.update',compact('motorRequirement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMotorRequirementRequest $request, string $id)
    {
        $validated=$request->validated();
        $motorRequirement=MototRequirement::findOrFail($id);
        $motorRequirement->update($validated);
        session()->flash('success','Motor Requirement is updated Successfully');
        return response()->redirectToRoute('motor-requirement.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $motorRequirement=MototRequirement::findOrFail($id);
         $motorRequirement->delete();
         session()->flash('danger','Motor Requirement is deleted successfully');
         return response()->redirectToRoute('motor-requirement.index');
    }
}
