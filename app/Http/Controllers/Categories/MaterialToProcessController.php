<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialToProcessRequest;
use App\Models\Machine;
use App\Models\MaterialToProcess;
use Illuminate\Http\Request;

class MaterialToProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mateiralToProcess=MaterialToProcess::orderByDesc('created_at')->get();
        $machines = Machine::all();
        return view('categories.material_to_process.index', compact('mateiralToProcess','machines'));
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
    public function store(StoreMaterialToProcessRequest $request)
    {
        $validated=$request->validated();
        MaterialToProcess::create($validated);
        session()->flash('success','Material Process is Successfully created');
        return redirect()->route('material-to-process.index');
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
        $materialToProcess=MaterialToProcess::with('model','model.machine')->findOrFail($id);
        // return $materialToProcess;
        $machines=Machine::all();
        return view('categories.material_to_process.update', compact('materialToProcess','machines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMaterialToProcessRequest $request, string $id)
    {
        $validated=$request->validated();
        $materialToProecess=MaterialToProcess::findOrFail($id);
        $materialToProecess->update($validated);
        session()->flash('success','Material Process is Successfully Updated');
        return redirect()->route('material-to-process.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $materialToProecessRequest=MaterialToProcess::findOrFail($id);
        $materialToProecessRequest->delete();
        session()->flash('danger','Material Process is Successfully Deleted!');
        return redirect()->route('material-to-process.index');
    }
}
