<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlowerRequest;
use App\Models\Blade;
use App\Models\Blower;
use App\Models\Machine;
use Illuminate\Http\Request;

class BlowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::all();
        $blowers = Blower::with(['model','model.machine'])->get();
        return view('categories.blowers.index', compact('blowers', 'machines'));
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
    public function store(StoreBlowerRequest $request)
    {
        $validated = $request->validated();

        Blower::create($validated);
        session()->flash('success', 'Blower is Successfully created');
        return redirect()->route('blowers.index');
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
        $blower = Blower::with('model', 'model.machine')->findOrFail($id);
        // return $materialToProcess;
        $machines = Machine::all();
        return view('categories.blowers.edit', compact('blower', 'machines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBlowerRequest $request, string $id)
    {
        $validated = $request->validated();
        $blower = Blower::findOrFail($id);
        $blower->update($validated);
        session()->flash('success', 'Blower is Successfully Updated');
        return redirect()->route('blowers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blower=Blower::findOrFail($id);
        $blower->delete();
        session()->flash('danger','Material Process is Successfully Deleted!');
        return redirect()->route('blowers.index');
    }
}
