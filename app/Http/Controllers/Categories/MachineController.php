<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMachineRequest;
use App\Models\Machine;
use App\Models\MachineType;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index(){
        $machineTypes=MachineType::all();
        $machines=Machine::with(['machineType'])->get();
        return response()->view('categories.machine.index',[
            'machineTypes'=> $machineTypes,
            'machines'=> $machines
        ]);
    }

    public function store(StoreMachineRequest $request){
        $data = $request->validated();
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images/machines', 'public');
            $data['image_url'] = $imagePath;
        }

        Machine::create($data);
        return response()->redirectToRoute('machine.index');
    }

    public function edit($id){
           $machine=Machine::with('machineType')->find($id);
           $machineTypes=MachineType::all();
           return response()->view('categories.machine.edit',[
            'machine'=> $machine,
            'machineTypes'=> $machineTypes
           ]);        
    }

    public function update(StoreMachineRequest $request, $id){
        $machine=Machine::find($id);
        $data=$request->validated();
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            $imagePath=public_path("storage/".$machine->image_url);
            if(file_exists($imagePath)){
                @unlink($imagePath);
            }
        }
        $imagePath=$request->file('image_url')->store('images/machines','public');
        // $imagePath=public_path("storage/".$imagePath);
        $data['image_url'] = $imagePath;
        $machine->update($data);
        return response()->redirectToRoute('machine.index');
    }

    public function destroy($id){
            $machine=Machine::find($id);
            $machine->delete();
            return response()->redirectToRoute('machine.index');
    }
}
