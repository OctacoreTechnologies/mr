<?php

namespace App\Http\Controllers\sale_orders;

use App\Http\Controllers\Controller;
use App\Models\AdvancePaymentLetter;
use App\Models\AcFequencyDrive;
use App\Models\Batch;
use App\Models\Bearing;
use App\Models\Blade;
use App\Models\Capacity;
use App\Models\DemoAdvancePaymentLetter;
use App\Models\ElelctricalControl;
use App\Models\Machine;
use App\Models\MakeMotor;
use App\Models\MaterialToProcess;
use App\Models\MixingTool;
use App\Models\Modele;
use App\Models\OrderAcceptanceLetter;
use App\Models\Pneumatic;
use App\Models\Quotation;
use App\Models\SaleOrder;
use App\Models\User;
use Illuminate\Http\Request;

class AdvancePaymentLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
        $saleOrder = SaleOrder::with(['quotation:id,id,machine_id'])->findOrFail($id);
        $machine_id = $saleOrder->quotation->machine_id ?? null;
        $orderAccptLtr = OrderAcceptanceLetter::where('sale_order_id', $id)->first();
        $fields = DemoAdvancePaymentLetter::where('machine_id', $machine_id)->first();
        $quotation = Quotation::with(['application', 'user', 'followedBy', 'machine', 'modele', 'materialToProcess', 'batch', 'mixingTool', 'electricalControl', 'acFrequencyDrive', 'bearinge', 'pneumatic', 'batche2'])->findOrFail($saleOrder->quotation->id);
        // dropdown's
        $product = $quotation->application;
        $machine = $quotation->machine;
        $model = $quotation->modele;
        $customer = $quotation->customer;

        // Fetch motor requirements for the model and machine
        $modeles = Modele::where('name', 'LIKE', '%' . $model->name . '%')
            ->orWhere('machine_id', $machine->id)
            // ->with(['motorRequirement', 'motorRequirement2'])
            ->get();
        $modeles2 = Modele::where('name', 'LIKE', '%' . $model->name . '%')
            ->orWhere('machine_id', $machine->id)
            ->with(['motorRequirement', 'motorRequirement2'])
            ->get();;

        // return $modeles;

        // Prepend the selected motor requirements
        $motorRequirements = $modeles2->pluck('motorRequirement')->unique('id');
        $motorRequirements2 = $modeles2->pluck('motorRequirement2')->unique('id');

        $motorRequirements = $motorRequirements->prepend($quotation->motorRequirement);
        $motorRequirements2 = $motorRequirements2->prepend($quotation->motorRequirement2);


        $batches = Batch::get();
        $mixingTools = MixingTool::all()->prepend($quotation->mixingTool);

        // Fetch other required data
        $materialToProcess = MaterialToProcess::all();
        $electricalControls = ElelctricalControl::all();
        $acFrequencyDrives = AcFequencyDrive::all();
        $bearings = Bearing::all();
        $pneumatics = Pneumatic::all();
        $machines = Machine::all();
        $users = User::all();
        $makeMotors = MakeMotor::all();

        // Get the rotating and fixed blades for the model
        $noOfRotatingBlades = Blade::where([
            'model_id' => $model->id,
            'type' => 'rotating_blades'
        ])->get();

        $noOfFixesBlades = Blade::where([
            'model_id' => $model->id,
            'type' => 'fix_blades'
        ])->get();

        // Get the capacities for the model
        $capacities = Capacity::where('model_id', $model->id)->get();

    //   return $acFrequencyDrives;
        return response()->view('sale_orders.oal.edit', [
            'orderAcceptanceLetter'=>$orderAccptLtr,
            'fields' => $fields,
            'quotation' => $quotation,
            'materialToProcess' => $materialToProcess,
            'batches' => $batches,  // Prepend batch
            'mixingTools' => $mixingTools,  // Prepend mixingTool
            'motors' => $motorRequirements,  // Prepend motorRequirement
            'motors2' => $motorRequirements2,  // Prepend motorRequirement2
            'model' => $model,
            'machine' => $machine,
            'product' => $product,
            'electricalControls' => $electricalControls,
            'acFrequencyDrives' => $acFrequencyDrives,
            'bearings' => $bearings,
            'pneumatics' => $pneumatics,
            'machines' => $machines,
            'users' => $users,
            'motor_makes' => $makeMotors,
            'noOfRotatingBlades' => $noOfRotatingBlades,
            'noOfFixesBlades' => $noOfFixesBlades,
            'capacities' => $capacities,
            'modeles'=>$modeles
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
