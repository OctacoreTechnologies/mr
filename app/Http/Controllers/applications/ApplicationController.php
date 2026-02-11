<?php

namespace App\Http\Controllers\applications;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\AcFequencyDrive;
use App\Models\Application;
use App\Models\Batch;
use App\Models\Bearing;
use App\Models\Blade;
use App\Models\Blower;
use App\Models\Capacity;
use App\Models\ElelctricalControl;
use App\Models\FeedingHooperCapacity;
use App\Models\Machine;
use App\Models\MakeMotor;
use App\Models\MaterialToProcess;
use App\Models\MixingTool;
use App\Models\Modele;
use App\Models\MototRequirement;
use App\Models\Pneumatic;
use App\Models\RotaryAirLockValve;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = Application::all();
    return response()->view('applications.index', [
      'products' => $products
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return response()->view('applications.create', [
      'materialToProcess' => MaterialToProcess::all(),
      'batchs' => Batch::all(),
      'mixingTools' => MixingTool::all(),
      'motorRequirements' => MototRequirement::all(),
      'models' => Modele::all(),
      'electricalControls' => ElelctricalControl::all(),
      'acFrequencyDrives' => AcFequencyDrive::all(),
      'bearings' => Bearing::all(),
      'pneumatics' => Pneumatic::all(),
      'machines' => Machine::all(),
      'makeMotors' => MakeMotor::all(),
      'rotatingBlades' => Blade::where('type', 'rotating')->get(),
      'fixedBlades' => Blade::where('type', 'fix')->get(),
      'capacities' => Capacity::all(),
      'blowers' => Blower::all(),
      'rotaryAirLockValves' => RotaryAirLockValve::all(),
      'feedingHooperCapacities' => FeedingHooperCapacity::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreApplicationRequest $request){
    $data = $this->prepareApplicationData($request->validated());

    Application::create($data);

    session()->flash('success', 'Product is added successfully');
    return redirect()->route('applications.index');
}


  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $product = Application::with(['modele'])->findOrFail($id);
    //  return $product;s
    return response()->view('applications.show', [
      "application" => $product,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $product = Application::findOrFail($id);

    return response()->view('applications.edit', [
      'product' => $product,
      'materialToProcess' => MaterialToProcess::all(),
      'batchs' => Batch::all(),
      'mixingTools' => MixingTool::all(),
      'motorRequirements' => MototRequirement::all(),
      'motorRequirements2' => MototRequirement::all(),
      'models' => Modele::all(),
      'electricalControls' => ElelctricalControl::all(),
      'acFrequencyDrives' => AcFequencyDrive::all(),
      'bearings' => Bearing::all(),
      'pneumatics' => Pneumatic::all(),
      'machines' => Machine::all(),
      'makeMotors' => MakeMotor::all(),
      'rotatingBlades' => Blade::all(),
      'fixedBlades' => Blade::all(),
      'capacities' => Capacity::all(),
      'blowers' => Blower::all(),
      'rotaryAirLockValves' => RotaryAirLockValve::all(),
      'feedingHooperCapacities' => FeedingHooperCapacity::all(),

    ]);
  }

  /**
   * Update the specified resource in storage.
   */
public function update(StoreApplicationRequest $request, string $id)
{
    $application = Application::findOrFail($id);

    $data = $this->prepareApplicationData(
        $request->validated(),
        true // update mode
    );

    $application->update($data);

    session()->flash('success', 'Application is updated successfully');
    return redirect()->route('applications.index');
}


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $product = Application::findOrFail($id);
    $product->delete();
    session()->flash('success', 'product is deleted successfully');

    return response()->redirectToRoute('applications.index');
  }

  public function applicationOptionsByMachine($machine_id)
  {
    $appications = Application::where('machine_id', $machine_id)->get(['id', 'name', 'price']);
    return response()->json(
      $appications
    );
  }

  protected function relationFields(): array
  {
    return [
      'material_to_process'     =>     [MaterialToProcess::class, 'material_to_process'],
      'motor_requirement'       =>     [MototRequirement::class, 'motor_requirement'],
      'motor_requirement2'      =>     [MototRequirement::class, 'motor_requirement'],
      'make_motor'              =>     [MakeMotor::class, 'name'],
      'batch'                   =>     [Batch::class, 'batches'],
      'batch2'                  =>     [Batch::class, 'batch2'],
      'mixing_tool'             =>     [MixingTool::class, 'mixing_tool'],
      'electrical_control'      =>     [ElelctricalControl::class, 'electrical_control'],
      'ac_frequency_drive'      =>     [AcFequencyDrive::class, 'ac_fequency_drive'],
      'bearing'                 =>     [Bearing::class, 'bearing'],
      'pneumatic'               =>     [Pneumatic::class, 'pneumatic'],
      'machine'                 =>     [Machine::class, 'name'],
      'no_of_rotating_blade'    =>     [Blade::class, 'no_of_blades'],
      'no_of_fixes_blade'       =>     [Blade::class, 'no_of_blades'],
      'capacity'                =>     [Capacity::class, 'capacity'],
      'blower'                  =>     [Blower::class, 'blower'],
      'rotary_air_lock_valve'   =>     [RotaryAirLockValve::class, 'rotary_air_lock_valve'],
      'feeding_hooper_capacity' =>     [FeedingHooperCapacity::class, 'feeding_hooper_capacity'],
    ];
  }

  protected function prepareApplicationData(array $data, bool $isUpdate = false): array
  {
    $relationFields = $this->relationFields();
    $foreignKeys = [];

    foreach ($relationFields as $field => [$model, $column]) {

      // Update case: field form me hi nahi aayi → skip
      if ($isUpdate && !array_key_exists($field, $data)) {
        continue;
      }

      if (!empty($data[$field])) {
        $record = $model::firstOrCreate([$column => $data[$field]]);
        $foreignKeys[$field . '_id'] = $record->id;
      } else {
        $foreignKeys[$field . '_id'] = null;
      }
    }

    return array_merge(
      collect($data)->except(array_keys($relationFields))->toArray(),
      $foreignKeys
    );
  }
}
