<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\categories\MotorRequirementController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateModelRequest;
use App\Models\Machine;
use App\Models\Modele;
use App\Models\MototRequirement;
use Illuminate\Http\Request;

class ModeleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models=Modele::with('application','machine')->orderByDesc('created_at')->get();
    //    return $models;
        $machines=Machine::all();
        return response()->view('categories.models.index',['models'=>$models,'machines'=>$machines,
        'motorRequirements'=>MototRequirement::all()]);
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
    public function store(UpdateModelRequest $request)
    {
        $data = $request->validated();
        $relationfields=[
          'motor'=>[MototRequirement::class,'motor_requirement'],
          'motor2'=>[MototRequirement::class,'motor_requirement'],
         ];
        $foreignKeys = [];
         foreach($relationfields as $field=>[$modelClass,$columnName]){
           if ($data[$field]!=null) {
            $record = $modelClass::firstOrCreate([$columnName => $data[$field]]);
            $foreignKeys[$field . '_id'] = $record->id;
           } else {
            $foreignKeys[$field . '_id'] = null;
           }
          }
        //  $modele = Modele::find($id);
          $finalData = array_merge(
        // Just regular fields
        collect($data)->except(array_keys($relationfields))->toArray(),

        // Foreign key fields
        $foreignKeys
    );
        Modele::create($finalData);
        return response()->redirectToRoute('model.index');
        
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
        $modele = Modele::find($id);
        $machines = Machine::all();
        $motorRequirements = MototRequirement::all();
        return response()->view('categories.models.edit',['model'=>$modele,'machines'=>$machines,'motorRequirements'=>$motorRequirements]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModelRequest $request, string $id)
    {
         $data=$request->validated();
         $relationfields=[
          'motor'=>[MototRequirement::class,'motor_requirement'],
         ];
        $foreignKeys = [];
         foreach($relationfields as $field=>[$modelClass,$columnName]){
           if ($data[$field]!=null) {
            $record = $modelClass::firstOrCreate([$columnName => $data[$field]]);
            $foreignKeys[$field . '_id'] = $record->id;
           } else {
            $foreignKeys[$field . '_id'] = null;
           }
          }
         $modele = Modele::find($id);
          $finalData = array_merge(
        // Just regular fields
        collect($data)->except(array_keys($relationfields))->toArray(),

        // Foreign key fields
        $foreignKeys
    );

         $modele->update($finalData);
         return response()->redirectToRoute('model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Modele::findOrFail($id)->delete();
        return response()->redirectToRoute('model.index');
    }

    public function getModelsByMachineId($id)
    {
        // $machineId = $request->input('machine_id');
        $models = Modele::where('machine_id', $id)->get();
        return response()->json($models);
    }
}
