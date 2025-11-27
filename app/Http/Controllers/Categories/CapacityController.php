<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\CapacityRequest;
use App\Models\Capacity;
use App\Models\Machine;
use App\Models\Modele;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capacities = Capacity::with('model')->get();
        $models=Modele::all();
        $machines=Machine::all();
        return view('categories.capacity.index', compact('capacities', 'models', 'machines'));
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
    public function store(CapacityRequest $request)
    {
        $data= $request->validated();
        Capacity::create($data);
        session()->flash('success', 'Capacity created successfully');
        return redirect()->route('capacity.index');
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
        $capacity = Capacity::findOrFail($id);
        $models= Modele::all();
        $machines= Machine::all();
        return view('categories.capacity.update', compact('capacity', 'models', 'machines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CapacityRequest $request, string $id)
    {
        $capacity = Capacity::findOrFail($id);
        $capacity->update($request->validated());
        session()->flash('success', 'Capacity updated successfully');
        return redirect()->route('capacity.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $capacity = Capacity::findOrFail($id);
        $capacity->delete();
        session()->flash('success', 'Capacity deleted successfully');
        return redirect()->route('capacity.index');  
    }
}
