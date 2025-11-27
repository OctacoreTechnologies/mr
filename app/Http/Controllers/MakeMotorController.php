<?php

namespace App\Http\Controllers;

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
        return response()->view('categories.make_motor.index',[
            'makeMotors'=>$makeMotors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMakeMotorRequest $request)
    {
        $validated=$request->validated();
        MakeMotor::create($validated);
        return response()->redirectToRoute('make-m',[]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MakeMotor $makeMotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MakeMotor $makeMotor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MakeMotor $makeMotor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MakeMotor $makeMotor)
    {
        //
    }
}
