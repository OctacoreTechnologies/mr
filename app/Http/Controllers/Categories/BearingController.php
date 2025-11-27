<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBearingRequest;
use App\Models\Bearing;
use Illuminate\Http\Request;

class BearingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bearings=Bearing::orderByDesc('created_at')->get();
        return response()->view('categories.bearing.index',compact('bearings'));
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
    public function store(StoreBearingRequest $request)
    {
        $validated=$request->validated();
        Bearing::create($validated);
        session()->flash('success','Bearing is Added Successfully');
        return response()->redirectToRoute('bearing.index');
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
        $bearing=Bearing::findOrFail($id);
        return response()->view('categories.bearing.update',compact('bearing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBearingRequest $request, string $id)
    {
          $bearing=Bearing::findOrFail($id);
          $bearing->update($request->validated());
          session()->flash('success','Bearing is Updated Successfuly');
          return response()->redirectToRoute('bearing.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $bearing=Bearing::findOrFail($id);
          $bearing->delete();
          session()->flash('danager','Bearing is Deleted Successfuly');
          return response()->redirectToRoute('bearing.index');
    }
}
