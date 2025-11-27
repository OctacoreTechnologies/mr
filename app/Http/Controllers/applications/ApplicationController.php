<?php

namespace App\Http\Controllers\applications;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\AcFequencyDrive;
use App\Models\Application;
use App\Models\Batch;
use App\Models\Bearing;
use App\Models\Blade;
use App\Models\Capacity;
use App\Models\ElelctricalControl;
use App\Models\Machine;
use App\Models\MakeMotor;
use App\Models\MaterialToProcess;
use App\Models\MixingTool;
use App\Models\Modele;
use App\Models\MototRequirement;
use App\Models\Pneumatic;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $products=Application::all();
          return response()->view('applications.index',[
            'products'=>$products
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return response()->view('applications.create',[
         'materialToProcess'=>MaterialToProcess::all(),
         'batchs'=>Batch::all(),
         'mixingTools'=>MixingTool::all(),
         'motorRequirements'=>MototRequirement::all(),
         'models'=>Modele::all(),
         'electricalControls'=>ElelctricalControl::all(),
         'acFrequencyDrives'=>AcFequencyDrive::all(),
         'bearings'=>Bearing::all(),
         'pneumatics'=>Pneumatic::all(),
         'machines'=>Machine::all(),
         'makeMotors'=>MakeMotor::all(),
         'rotatingBlades'=>Blade::where('type','rotating')->get(),
         'fixedBlades'=>Blade::where('type','fix')->get(),
         'capacities'=>Capacity::all(),
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
      $relationfields=[
        'material_to_process'=>[MaterialToProcess::class,'material_to_process'],
        'motor_requirement'=>[MototRequirement::class,'motor_requirement'],
        'motor_requirement2'=>[MototRequirement::class,'motor_requirement'],
        'make_motor'=>[MakeMotor::class,'name'],
        'batch'=>[Batch::class,'batches'],
        'batch2'=>[Batch::class,'batch2'],
        'mixing_tool'=>[MixingTool::class,'mixing_tool'],
        'electrical_control'=>[ElelctricalControl::class,'electrical_control'],
        'ac_frequency_drive'=>[AcFequencyDrive::class,'ac_fequency_drive'],
        'bearing'=>[Bearing::class,'bearing'],
        'pneumatic'=>[Pneumatic::class,'pneumatic'],
        'machine'=>[Machine::class,'name'],
        'no_of_rotating_blade'=>[Blade::class,'no_of_blades'],
        'no_of_fixes_blade'=>[Blade::class,'no_of_blades'],
        'capacity'=>[Capacity::class,'capacity'],
       ];
          $data = $request->validated();
          $foreignKeys = [];

          foreach($relationfields as $field=>[$modelClass,$columnName]){
           if ($data[$field]!=null) {
            $record = $modelClass::firstOrCreate([$columnName => $data[$field]]);
            $foreignKeys[$field . '_id'] = $record->id;
           } else {
            $foreignKeys[$field . '_id'] = null;
           }
          }

       $finalData = array_merge(
        // Just regular fields
        collect($data)->except(array_keys($relationfields))->toArray(),

        // Foreign key fields
        $foreignKeys
    );

    // return $finalData;
        
          Application::create($finalData);
          session()->flash('success','product is added successfully');
          return response()->redirectToRoute('applications.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $product=Application::with(['modele'])->findOrFail($id);
        //  return $product;s
        return response()->view('applications.show',[
            "application"=>$product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=Application::findOrFail($id);

        return response()->view('applications.edit',[
         'product'=>$product,
         'materialToProcess'=>MaterialToProcess::all(),
         'batchs'=>Batch::all(),
         'mixingTools'=>MixingTool::all(),
         'motorRequirements'=>MototRequirement::all(),
         'motorRequirements2'=>MototRequirement::all(),
         'models'=>Modele::all(),
         'electricalControls'=>ElelctricalControl::all(),
         'acFrequencyDrives'=>AcFequencyDrive::all(),
         'bearings'=>Bearing::all(),
         'pneumatics'=>Pneumatic::all(),
         'machines'=>Machine::all(),
         'makeMotors'=>MakeMotor::all(),
         'rotatingBlades'=>Blade::where('type','rotating_blades')->get(),
         'fixedBlades'=>Blade::where('type','fix_blades')->get(),
         'capacities'=>Capacity::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreApplicationRequest $request, string $id)
    {
         $product=Application::findOrFail($id);
         $product->update($request->validated());
         session()->flash('success','Application is updated successfully');
         return response()->redirectToRoute("applications.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Application::findOrFail($id);
        $product->delete();
        session()->flash('success','product is deleted successfully');

        return response()->redirectToRoute('applications.index');
    }

    public function applicationOptionsByMachine($machine_id){
         $appications=Application::where('machine_id',$machine_id)->get(['id','name','price']);
         return response()->json(
           $appications
         );
    }
}
