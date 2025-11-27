<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\MachineTypeRequest;
use App\Http\Requests\UpdateMachineRequest;
use App\Models\Machine;
use App\Models\MachineType;
use Illuminate\Http\Request;

class MachineTypeController extends Controller
{
    public function index(){
         $machineTypes = MachineType::all();
         return response()->view('categories.machine_types.index',[
            'machineTypes'=> $machineTypes
         ]);
    }
    public function store(MachineTypeRequest $request){
            MachineType::create($request->validated());
            return response()->redirectToRoute('machine-type.index');
    }

    public function edit($id){
        $machineType = MachineType::with(['machines'])->findOrFail($id);
        return response()->view('categories.machine_types.edit',compact('machineType'));
    }

    public function update(UpdateMachineRequest $request, $id)
{
    $validated = $request->validated();

    $machineType = MachineType::findOrFail($id);
    $machineType->update(['name' => $validated['name']]);

    $existingMachines = $machineType->machines()->get(); // Collection of existing machines
    $newMachineNames = $validated['machine'];

    // Track machine IDs that have been updated or reused
    $processedIds = [];

    foreach ($newMachineNames as $index => $machineName) {
        // If an existing machine at this index exists, update it
        if (isset($existingMachines[$index])) {
            $existingMachines[$index]->update(['name' => $machineName]);
            $processedIds[] = $existingMachines[$index]->id;
        } else {
            // Create new machine
            $newMachine = $machineType->machines()->create(['name' => $machineName]);
            $processedIds[] = $newMachine->id;
        }
    }

    // Delete machines that are no longer in the submitted form
    $machineType->machines()
        ->whereNotIn('id', $processedIds)
        ->delete();

    return redirect()->route('machine-type.index')->with('success', 'Machine Type updated successfully.');
}


    public function destroy($id){
        $types = MachineType::findOrFail($id);
        $types->delete();
        return response()->redirectToRoute('machine-type.index');
    }
    public function getMachines($machineTypeId)
    {
        $machines = Machine::where('machine_type_id', $machineTypeId)->get();
    
        return response()->json($machines);
    }

}
