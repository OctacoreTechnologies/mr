<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMakeMotorRequest;
use App\Models\MakeMotor;
use Illuminate\Http\Request;

class MakeMotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $makeMotors=MakeMotor::orderByDesc('created_at')->get();
          return response()->view('categories.motor_make.index',[
              'motorMakes'=>$makeMotors,
          ]);
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
    public function store(StoreMakeMotorRequest $request)
    {
        $validated=$request->validated();
        MakeMotor::create($validated);
        return response()->redirectToRoute('make-motor.index')->with('success','Make Motor Added Successfully');
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
        $makeMotor=MakeMotor::findOrFail($id);
        return response()->view('categories.motor_make.edit',[
            'makeMotor'=>$makeMotor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMakeMotorRequest $request, string $id)
    {
        $validated=$request->validated();
        MakeMotor::findOrFail($id)->update($validated);
        return response()->redirectToRoute('make-motor.index')->with('success','Make Motor is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MakeMotor::findOrFail($id)->delete();
        return response()->redirectToRoute('motor-make.index')->with('success','Make Motor is deleted successfully');
    }
}
