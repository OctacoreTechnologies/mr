<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedingHooperCapacityRequest;
use App\Models\FeedingHooperCapacity;
use App\Models\Machine;
use Illuminate\Http\Request;

class FeedingHooperCapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::all();
        $feedingHooperCapacities = FeedingHooperCapacity::with(['model', 'model.machine'])->get();
        return view('categories.feeding_hooper_capacities.index', compact('feedingHooperCapacities', 'machines'));
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
    public function store(FeedingHooperCapacityRequest $request)
    {
        $validated = $request->validated();

        FeedingHooperCapacity::create($validated);
        session()->flash('success', 'Feeding Hooper Capacity is Successfully created');
        return redirect()->route('feeding_hooper_capacities.index');
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
        $feedingHooperCapacity = FeedingHooperCapacity::with('model', 'model.machine')->findOrFail($id);

        $machines = Machine::all();
        return view('categories.feeding_hooper_capacities.edit', compact('feedingHooperCapacity', 'machines'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(FeedingHooperCapacityRequest $request, string $id)
    {
        $validated = $request->validated();
        $feedingHooperCapacity = FeedingHooperCapacity::findOrFail($id);
        $feedingHooperCapacity->update($validated);
        session()->flash('success', 'Feeding Hooper Capacity is Successfully Updated');
        return redirect()->route('feeding_hooper_capacities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        
        $feedingHooperCapacity=FeedingHooperCapacity::findOrFail($id);
        $feedingHooperCapacity->delete();
        session()->flash('danger','Feeding Hooper Capacity is Successfully Deleted!');
        return redirect()->route('feeding_hooper_capacities.index');
    }
}
