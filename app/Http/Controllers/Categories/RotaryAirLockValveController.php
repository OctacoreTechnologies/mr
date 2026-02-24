<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\RotaryAirLockValveRequest;
use App\Models\Machine;
use App\Models\RotaryAirLockValve;
use Illuminate\Http\Request;

class RotaryAirLockValveController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::all();
        $rotaryAirLockValves= RotaryAirLockValve::with(['model', 'model.machine'])->get();
        return view('categories.rotary_air_lock_valves.index', compact('rotaryAirLockValves', 'machines'));
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
    public function store(RotaryAirLockValveRequest $request)
    {
        $validated = $request->validated();

        RotaryAirLockValve::create($validated);
        session()->flash('success', 'Rotary Air Lock Valve is Successfully created');
        return redirect()->route('rotary-air-lock-valves.index');
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
        $rotaryAirLockValve = RotaryAirLockValve::with('model', 'model.machine')->findOrFail($id);

        $machines = Machine::all();
        return view('categories.rotary_air_lock_valves.edit', compact('rotaryAirLockValve', 'machines'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(RotaryAirLockValveRequest $request, string $id)
    {
        $validated = $request->validated();
        $RotaryAirLockValve = RotaryAirLockValve::findOrFail($id);
        $RotaryAirLockValve->update($validated);
        session()->flash('success', 'Rotary Air Lock Valve is Successfully Updated');
        return redirect()->route('rotary-air-lock-valves.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $RotaryAirLockValve = RotaryAirLockValve::findOrFail($id);
        $RotaryAirLockValve->delete();
        session()->flash('danger', 'Rotary Air Lock Valve is Successfully Deleted!');
        return redirect()->route('rotary-air-lock-valves.index');
    }
}
