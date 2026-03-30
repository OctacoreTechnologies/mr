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
use App\Models\DriveSystem;
use App\Models\ElelctricalControl;
use App\Models\FeedingHooperCapacity;
use App\Models\GearBox;
use App\Models\Machine;
use App\Models\MakeMotor;
use App\Models\MaterialToProcess;
use App\Models\MixingTool;
use App\Models\Modele;
use App\Models\MototRequirement;
use App\Models\Pneumatic;
use App\Models\RotaryAirLockValve;

class ApplicationController extends Controller
{
    // ===================== Index =====================

    public function index()
    {
        $products = Application::all();
        return response()->view('applications.index', [
            'products' => $products,
        ]);
    }

    // ===================== Create =====================

    public function create()
    {
        return response()->view('applications.create', $this->getFormData());
    }

    // ===================== Store =====================

    public function store(StoreApplicationRequest $request)
    {
        $data = $this->prepareApplicationData($request->validated());

        Application::create($data);

        session()->flash('success', 'Product is added successfully');
        return redirect()->route('applications.index');
    }

    // ===================== Show =====================

    public function show(string $id)
    {
        $product = Application::with(['modele'])->findOrFail($id);

        return response()->view('applications.show', [
            'application' => $product,
        ]);
    }

    // ===================== Edit =====================

    public function edit(string $id)
    {
        $product = Application::findOrFail($id);

        return response()->view('applications.edit', array_merge(
            ['product' => $product],
            $this->getFormData()
        ));
    }

    // ===================== Update =====================

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

    // ===================== Destroy =====================

    public function destroy(string $id)
    {
        $product = Application::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product is deleted successfully');
        return redirect()->route('applications.index');
    }

    // ===================== API — Options by Machine =====================

    public function applicationOptionsByMachine($machine_id)
    {
        $applications = Application::where('machine_id', $machine_id)
            ->get(['id', 'name', 'price']);

        return response()->json($applications);
    }

    // ===================== Shared Form Data =====================

    private function getFormData(): array
    {
        return [
            'machines'                => Machine::orderBy('name')->get(),
            'models'                  => Modele::all(),
            'capacities'              => Capacity::all(),
            'materialToProcess'       => MaterialToProcess::all(),
            'rotatingBlades'          => Blade::where('type', 'rotating_blades')->get(),
            'fixedBlades'             => Blade::where('type', 'fix_blades')->get(),
            'blowers'                 => Blower::all(),
            'rotaryAirLockValves'     => RotaryAirLockValve::all(),
            'feedingHooperCapacities' => FeedingHooperCapacity::all(),
            'motorRequirements'       => MototRequirement::all(),
            'makeMotors'              => MakeMotor::all(),
            'batchs'                  => Batch::all(),
            'mixingTools'             => MixingTool::all(),
            'electricalControls'      => ElelctricalControl::all(),
            'acFrequencyDrives'       => AcFequencyDrive::all(),
            'bearings'                => Bearing::all(),
            'pneumatics'              => Pneumatic::all(),
            'driveSystems'            => DriveSystem::all(),
            'gearboxes'               => GearBox::all(),
        ];
    }

    // ===================== Relation Fields Map =====================

    protected function relationFields(): array
    {
        return [
            // Material
            'material_to_process'     => [MaterialToProcess::class,     'material_to_process'],

            // Blades
            'no_of_rotating_blade'    => [Blade::class,                 'no_of_blades'],
            'no_of_fixes_blade'       => [Blade::class,                 'no_of_blades'],

            // Blower & Valves
            'blower'                  => [Blower::class,                'blower'],
            'rotary_air_lock_valve'   => [RotaryAirLockValve::class,    'rotary_air_lock_valve'],
            'feeding_hooper_capacity' => [FeedingHooperCapacity::class, 'feeding_hooper_capacity'],
            'capacity'                => [Capacity::class,              'capacity'],

            // Machine
            'machine'                 => [Machine::class,               'name'],

            // Application 1 — Motor & Config
            'motor_requirement'       => [MototRequirement::class,      'motor_requirement'],
            'make_motor'              => [MakeMotor::class,              'name'],
            'batch'                   => [Batch::class,                  'batches'],
            'mixing_tool'             => [MixingTool::class,             'mixing_tool'],
            'electrical_control'      => [ElelctricalControl::class,     'electrical_control'],
            'ac_frequency_drive'      => [AcFequencyDrive::class,        'ac_fequency_drive'],
            'bearing'                 => [Bearing::class,                'bearing'],
            'pneumatic'               => [Pneumatic::class,              'pneumatic'],
            // 'drive_system'          => [DriveSystem::class,            'drive_system'],
            // 'gear_box_1'              => [GearBox::class,                'gear_box'],

            // Application 2 — Motor & Config
            'motor_requirement2'       => [MototRequirement::class,       'motor_requirement'],
            'make_motor_2'             => [MakeMotor::class,              'name'],
            'batch2'                   => [Batch::class,                  'batches'],
            'electrical_control_2'     => [ElelctricalControl::class,     'electrical_control'],
            'ac_frequency_drive_2'     => [AcFequencyDrive::class,        'ac_fequency_drive'],
            'bearing_2'                => [Bearing::class,                'bearing'],
            'pneumatic_2'              => [Pneumatic::class,              'pneumatic'],
            // 'drive_system_2'           => [DriveSystem::class,            'drive_system'],
            // 'gear_box_2'               => [GearBox::class,                'gear_box'],
        ];
    }

    // ===================== Prepare Data Helper =====================

    protected function prepareApplicationData(array $data, bool $isUpdate = false): array
    {
        $relationFields = $this->relationFields();
        $foreignKeys = [];

        foreach ($relationFields as $field => [$model, $column]) {

            // Update case: field form me nahi aayi → skip
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