<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\BladeRequest;
use App\Models\Blade;
use App\Models\Machine;
use App\Models\Modele;
use Illuminate\Http\Request;

class BladeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Modele::all();
        $machines=Machine::all();
        $blades=Blade::with(['machine','model'])->get();
        return view('categories.blades.index', compact('models', 'machines', 'blades'));
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
    public function store(BladeRequest $request)
    {
        Blade::create($request->validated());
        session()->flash('success', 'Blade created successfully.');
        return redirect()->route('blade.index')->with('success', 'Blade created successfully.');

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
        $blade = Blade::findOrFail($id);
        $models = Modele::all();
        $machines = Machine::all();
        return view('categories.blades.edit', compact('blade', 'models', 'machines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BladeRequest $request, string $id)
    {
        $blade = Blade::findOrFail($id);
        $blade->update($request->validated());
        session()->flash('success', 'Blade updated successfully.');
        return redirect()->route('blades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blade = Blade::findOrFail($id);
        $blade->delete();
        session()->flash('success', 'Blade deleted successfully.');
        return redirect()->route('blade.index');
    }
}
