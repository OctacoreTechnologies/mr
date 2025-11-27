<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreElectricalControllerRequest;
use App\Models\ElelctricalControl;
use Illuminate\Http\Request;

class ElectricalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $electricals=ElelctricalControl::orderByDesc('created_at')->get();
        return response()->view('categories.electrical_control.index',compact('electricals'));
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
    public function store(StoreElectricalControllerRequest $request)
    {
        $validated=$request->validated();
        ElelctricalControl::create($validated);
        session()->flash('success','Electrical Control Added Successfully');
        return response()->redirectToRoute('electrical-control.index');
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
        $electric=ElelctricalControl::findOrFail($id);
        return response()->view('categories.electrical_control.update',['electrical'=>$electric]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreElectricalControllerRequest $request, string $id)
    {
        $validated=$request->validated();
        ElelctricalControl::findOrFail($id)->update($validated);
        session()->flash('success','Electrical Control is Updated Successfully');
        return response()->redirectToRoute('electrical-control.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ElelctricalControl::findOrFail($id)->delete();
        session()->flash('danger','Electrical Control is deleted Successfully');
        return response()->redirectToRoute('electrical-control.index');
    }
}
