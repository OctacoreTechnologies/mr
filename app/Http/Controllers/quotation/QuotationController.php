<?php

namespace App\Http\Controllers\quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\FullUpdateQuotationRequest;
use App\Http\Requests\PreviewRequest;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\AcFequencyDrive;
use App\Models\Application;
use App\Models\Batch;
use App\Models\Bearing;
use App\Models\Blade;
use App\Models\Blower;
use App\Models\Capacity;
use App\Models\Customer;
use App\Models\MachineType;
use App\Models\Modele;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\TearmCondition;
use App\Notifications\QuotationReminderNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use App\Models\ElelctricalControl;
use App\Models\FeedingHooperCapacity;
use App\Models\Machine;
use App\Models\MakeMotor;
use App\Models\MaterialToProcess;
use App\Models\MixingTool;
use App\Models\MototRequirement;
use App\Models\Pneumatic;
use App\Models\QuotationNotification;
use App\Models\Reminder;
use App\Models\RotaryAirLockValve;
use App\Models\SaleOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\isEmpty;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = now()->year;

        // Calculate the start and end of the financial year
        // Financial Year runs from April to March
        $startDate = now()->month >= 4 ? Carbon::create($currentYear, 4, 1) : Carbon::create($currentYear - 1, 4, 1);
        $endDate = $startDate->copy()->addYear()->subDay();
        $quotations = Quotation::with(['product', 'customer'])->whereBetween('created_at', [$startDate, $endDate])->orderByDesc('updated_at')->get();

        return response()->view('quotations.index', [
            "quotations" => $quotations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $opportunities=Opportunity::all();
        $previewData = session('previewData');


        $product = Application::findOrFail($previewData['application_id']);


        $machineTypes = MachineType::all();
        $machine = Machine::findOrFail($previewData['machine_id']);
        $model = Modele::findOrFail($previewData['model_id']);
        // $cleints = Customer::all();
        $customer = Customer::findOrFail($previewData['customer_id']);
        $materialToProcess = MaterialToProcess::all();
        $batchs = Batch::all();
        $mixingTools = MixingTool::all();
        $modeles = Modele::where('name', 'LIKE', '%' . $model->name . '%')->where('machine_id', $previewData['machine_id'])->with(['motorRequirement', 'motorRequirement2'])->get();

        $motorRequirements = $modeles->pluck('motorRequirement')->unique('id');
        $motorRequirements2 = $modeles->pluck('motorRequirement2')->unique('id');
        $machineTypes = MachineType::all();

        return response()->view('quotations.create', [
            // 'opportunities'=>$opportunities,
            'customer' => $customer,
            'materialToProcess' => $materialToProcess,
            'batchs' => $batchs,
            'mixingTools' => $mixingTools,
            'motorRequirements' => $motorRequirements,
            'motorRequirements2' => $motorRequirements2,
            'model' => $model,
            'machine' => $machine,
            'product' => $product,
            'previewData' => $previewData,
            'electricalControls' => ElelctricalControl::all(),
            'acFrequencyDrives' => AcFequencyDrive::all(),
            'bearings' => Bearing::all(),
            'pneumatics' => Pneumatic::all(),
            'machines' => Machine::all(),
            'users' => User::all(),
            'makeMotors' => MakeMotor::all(),
            'noOfRotatingBlades' => Blade::where(['model_id' => $previewData['model_id'], 'type' => 'rotating_blades'])->get(),
            'noOfFixesBlades' => Blade::where(['model_id' => $previewData['model_id'], 'type' => 'fix_blades'])->get(),
            'capacities' => Capacity::where('model_id', $previewData['model_id'])->get(),
            'batches' => Batch::where('model_id', $previewData['model_id'])->get(),
            'blowers' => Blower::where('model_id', $previewData['model_id'])->get(),
            'rotaryAirLockValves' => RotaryAirLockValve::where('model_id', $previewData['model_id'])->get(),
            'feedingHooperCapacities' => FeedingHooperCapacity::where('model_id', $previewData['model_id'])->get(),


        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuotationRequest $request)
    {
        $validated = $request->validated();

        $relationfields = [
            'material_to_process' => [MaterialToProcess::class, 'material_to_process'],
            'motor_requirement' => [MototRequirement::class, 'motor_requirement'],
            'motor_requirement2' => [MototRequirement::class, 'motor_requirement'],
            'make_motor' => [MakeMotor::class, 'name'],
            'batch' => [Batch::class, 'batches'],
            'batch2' => [Batch::class, 'batches'],
            'mixing_tool' => [MixingTool::class, 'mixing_tool'],
            'electrical_control' => [ElelctricalControl::class, 'electrical_control'],
            'ac_frequency_drive' => [AcFequencyDrive::class, 'ac_fequency_drive'],
            'bearing' => [Bearing::class, 'bearing'],
            'pneumatic' => [Pneumatic::class, 'pneumatic'],
            //   'model'=>[Modele::class,'name'],
            'blower' => [Blower::class, 'blower'],
            'rotary_air_lock_valve' => [RotaryAirLockValve::class, 'rotary_air_lock_valve'],
            'feeding_hooper_capacity' => [FeedingHooperCapacity::class, 'feeding_hooper_capacity'],
        
        ];

        $foreignKeys = [];

        foreach ($relationfields as $field => [$modelClass, $columnName]) {
            if (isset($validated[$field]) && $validated[$field] != null) {
                $record = $modelClass::firstOrCreate([$columnName => $validated[$field]]);
                $foreignKeys[$field . '_id'] = $record->id;
            } else {
                $foreignKeys[$field . '_id'] = null;
            }
        }

        $finalData = array_merge(
            // Just regular fields
            collect($validated)->except(array_keys($relationfields))->toArray(),

            // Foreign key fields
            $foreignKeys
        );


        Quotation::create($finalData);
        session()->flash('success', 'quotation is created successfully');

        return response()->redirectToRoute('quotation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quotation = Quotation::with(['customer', 'application'])->findOrFail($id);
        return response()->view('quotations.show', [
            "quotation" => $quotation
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $opportunities=Opportunity::all();
        $products = Application::all();
        $cleints = Customer::all();
        // return $opportunities;
        $quotation = Quotation::findOrFail($id);
        return response()->view('quotations.edit', [
            "quotation" => $quotation,
            'products' => $products,
            'customers' => $cleints,
            'users' => User::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuotationRequest $request, string $id)
    {
        $validated = $request->validated();
        $quotation = Quotation::findOrFail($id);
        $referenceNo = $quotation->reference_no;
        if (isset($validated['revise']) && $validated['revise']) {
            $referenceNo = $this->getNextReference($referenceNo);
            unset($validated['revise']);
        }
        $validated['reference_no'] = $referenceNo;

        $quotation->update(collect($validated)->except('reminder_date')->toArray());
        if (!is_null($validated['reminder_date']) && $validated['reminder_date'] != $quotation->remider_date) {
            Reminder::create([
                'type_id' => $quotation->id,
                'type' => 'quotation sent remidner',
                'sent_date' => $validated['reminder_date'],
                'data' => 'To Sent this Quotation to a Customer',
                'model' => 'Quotation'
            ]);
        }
        if ($quotation->status == 'Approved') {
            $this->updateSts($id, 'Approved');
        }
        session()->flash('success', 'quotation is updated successfully');
        // Notification::send(User::all(),new QuotationReminderNotification($quotation));
        return response()->redirectToRoute('quotation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
        session()->flash('quotation is deleted successfully');
        return response()->redirectToRoute('quotation.index');
    }

    public function viewPdf($id)
    {
        $numberWords = new NumberToWords();
        $numberTransformer = $numberWords->getNumberTransformer('en');
        $termCondition = TearmCondition::findOrFail(1);
        $quotation = Quotation::with(['customer', 'application', 'user', 'followedBy', 'machine', 'modele', 'materialToProcess', 'batch', 'mixingTool', 'electricalControl', 'acFrequencyDrive', 'bearinge', 'pneumatic', 'batche2','blower','rotaryAirLockValve','feedingHooperCapacity'])->findOrFail($id);
        $words = convertToIndianWords((int) ($quotation->total_price ?? 0) - (int) ($quotation->discount ?? 0));
        $viewName = null;
        if ($quotation->machine->name == 'High Speed Heater Mixer') {
            $viewName = "quotations.new_pdf";
        } else if ($quotation->machine->name == 'Vertical Cooler Mixer') {
            $viewName = "quotations.pdfs.vertical_cooler_mixture";
        } else if ($quotation->machine->name == 'Grinder') {
            $viewName = "quotations.pdfs.grinder";
        } else if ($quotation->machine->name == 'High-Speed Heater and Vertical Cooler Mixer') {
            $viewName = "quotations.pdfs.high_speed_heater_and_vertical_cooler_mixture";
        } else if ($quotation->machine->name == 'High-Speed Heater and Horizontal Cooler') {
            $viewName = "quotations.pdfs.high_speed_heater_and_horizontal_cooler";
        } else if ($quotation->machine->name == 'Pulverizer') {
            $viewName = "quotations.pdfs.pulverizer";
        } else if ($quotation->machine->name == 'Agglomerator') {
            $viewName = "quotations.pdfs.agglomerator";
        }  
        else {
            $viewName = "quotations.new_pdf";
        }
        $pdf = Pdf::loadView($viewName, [
            "quotation" => $quotation,
            'termCondition' => $termCondition,
            'words' => $words,
            'isJob' => false,
        ])->setOption([
            'fontDir' => public_path('/fonts'),
            'fontCache' => public_path('/fonts'),
            'defaultFont' => 'Poppins',
            'isRemoteEnabled' => true
        ]);
        return $pdf->stream('quotation');
    }

    public function previewForm()
    {
        $products = Application::all();
        $machineTypes = MachineType::all();
        $models = Modele::all();
        $cleints = Customer::all();
        //  $referenceNO = Quotation::count() + 1;
        $referenceNO = Quotation::withTrashed()->count() + 1;
        $today = now(); // Or Carbon::now()

        // Determine financial year
        $year = $today->year;
        $month = $today->month;


        if ($month >= 4) {
            // April to December
            $financialYear = $year . '-' . substr($year + 1, -2);
        } else {
            // January to March
            $financialYear = ($year - 1) . '-' . substr($year, -2);
        }

        $referenceNO = str_pad($referenceNO, 3, '0', STR_PAD_LEFT);
        $formattedReferenceNo = 'MR/' . $referenceNO . '/' . $financialYear;
        return response()->view('quotations.preview', [
            // 'opportunities'=>$opportunities,
            'customers' => $cleints,
            'products' => $products,
            'machineTypes' => $machineTypes,
            'models' => $models,
            'reference_no' => $formattedReferenceNo
        ]);
    }

    public function preview(PreviewRequest $request)
    {

        $validated = $request->validated();
        // return $validated;
        session(['previewData' => $validated]);
        return redirect()->route('quotation.create');
    }

    function getNextReference($inputRef)
    {

        if (preg_match('/^(.*)\/(\d+)R$/', $inputRef, $matches)) {
            $baseRef = $matches[1];
            $currentNumber = intval($matches[2]);
            $nextNumber = $currentNumber + 1;
            return $baseRef . '/R' . $nextNumber; // Ensure the format R1, R2, R3, etc.
        } else {

            if (preg_match('/^(.*)\/R(\d+)$/', $inputRef, $matches)) {
                $baseRef = $matches[1];           // e.g. MR/007/2025-26
                $currentNumber = intval($matches[2]);
                $nextNumber = $currentNumber + 1; // Increase by 1
                return $baseRef . '/R' . $nextNumber; // Ensure the format R1, R2, R3, etc.
            } else {

                return $inputRef . '/R1';
            }
        }
    }

    public function isVerified(Request $request)
    {
        $quotation = Quotation::findOrFail($request->id);
        $quotation->is_verified = $request->is_verified;
        $quotation->save();

        return response()->redirectToRoute('quotation.index')->with('success', 'Quotation is verified successfully');
    }


    public function full_edit($id)
    {
        // Load the quotation and related models
        $quotation = Quotation::with([
            'customer',
            'application',
            'user',
            'machine',
            'modele',
            'materialToProcess',
            'batch',
            'mixingTool',
            'electricalControl',
            'acFrequencyDrive',
            'bearinge',
            'pneumatic',
            'motorRequirement',  // Ensure motorRequirement is loaded
            'motorRequirement2', // Ensure motorRequirement2 is loaded
        ])->findOrFail($id);

        // Get the data for the form
        $product = $quotation->application;
        $machine = $quotation->machine;
        $model = $quotation->modele;
        $customer = $quotation->customer;

        // Fetch motor requirements for the model and machine
        $modeles = Modele::where('name', 'LIKE', '%' . $model->name . '%')
            ->where('machine_id', $machine->id)
            ->with(relations: ['motorRequirement', 'motorRequirement2'])
            ->get();

        // Prepend the selected motor requirements
        $motorRequirements = $modeles->pluck('motorRequirement')->unique('id');
        $motorRequirements2 = $modeles->pluck('motorRequirement2')->unique('id');

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

        // Pass the selected data to the view
        return view('quotations.fulledit', [
            'quotation' => $quotation,
            'customer' => $customer,
            'materialToProcess' => $materialToProcess,
            'batches' => $batches,  // Prepend batch
            'mixingTools' => $mixingTools,  // Prepend mixingTool
            'motorRequirements' => $motorRequirements,  // Prepend motorRequirement
            'motorRequirements2' => $motorRequirements2,  // Prepend motorRequirement2
            'model' => $model,
            'machine' => $machine,
            'product' => $product,
            'electricalControls' => $electricalControls,
            'acFrequencyDrives' => $acFrequencyDrives,
            'bearings' => $bearings,
            'pneumatics' => $pneumatics,
            'machines' => $machines,
            'users' => $users,
            'makeMotors' => $makeMotors,
            'noOfRotatingBlades' => $noOfRotatingBlades,
            'noOfFixesBlades' => $noOfFixesBlades,
            'capacities' => $capacities,
        ]);
    }




    //   FUll Update

    public function full_update(FullUpdateQuotationRequest $request, $id)
    {
        // Retrieve the quotation to update
        $quotation = Quotation::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validated();

        // Define relation fields for the quotation
        $relationfields = [
            'material_to_process' => [MaterialToProcess::class, 'material_to_process'],
            'motor_requirement' => [MototRequirement::class, 'motor_requirement'],
            'motor_requirement2' => [MototRequirement::class, 'motor_requirement'],
            'make_motor' => [MakeMotor::class, 'name'],
            'batch' => [Batch::class, 'batches'],
            'batch2' => [Batch::class, 'batches'],
            'mixing_tool' => [MixingTool::class, 'mixing_tool'],
            'electrical_control' => [ElelctricalControl::class, 'electrical_control'],
            'ac_frequency_drive' => [AcFequencyDrive::class, 'ac_fequency_drive'],
            'bearing' => [Bearing::class, 'bearing'],
            'pneumatic' => [Pneumatic::class, 'pneumatic'],
        ];

        // Initialize foreign keys array
        $foreignKeys = [];

        // Iterate over each field and handle relation creation or update
        foreach ($relationfields as $field => [$modelClass, $columnName]) {
            if (isset($validated[$field]) && $validated[$field] != null) {
                // Update the existing record if it exists, otherwise create a new one
                $record = $modelClass::firstOrCreate([$columnName => $validated[$field]]);
                $foreignKeys[$field . '_id'] = $record->id;
            } else {
                // If the field is not provided, set it to null
                $foreignKeys[$field . '_id'] = null;
            }
        }

        // Handle the model_id specifically
        if (isset($validated['model_id']) && $validated['model_id'] != null) {
            $model = Modele::find($validated['model_id']);
        } else {
            // If model_id is not provided, fallback to the first available model
            $model = Modele::first(); // Fallback to the first model
        }

        if ($model) {
            $foreignKeys['model_id'] = $model->id;
        } else {
            // If no model is found or provided, set to null or handle as necessary
            $foreignKeys['model_id'] = null;
        }

        // Combine the validated fields and the foreign key fields
        $finalData = array_merge(
            // Regular fields (excluding relations)
            collect($validated)->except(array_keys($relationfields))->toArray(),

            // Foreign key fields
            $foreignKeys
        );

        // Update the existing quotation with the final data
        $quotation->update($finalData);

        // Flash success message
        session()->flash('success', 'Quotation is updated successfully');

        // Redirect to the quotations index page
        return response()->redirectToRoute('quotation.index');
    }

    public function updateStatus(Request $request)
    {
        $saleOrder = $this->updateSts($request->id, $request->status);
        //    $quotation=Quotation::findOrFail($request->id);
        //    $quotation->status=$request->status;
        //    $quotation->save();
        //    if($quotation->status == 'Approved'){
        //        $saleOrder=SaleOrder::where('quotation_id',$quotation->id)->latest()->first();
        //                 if(is_null($saleOrder)){
        //                     SaleOrder::create([
        //                         'quotation_id'          =>        $quotation->id,
        //                         'status'                =>        'pending',
        //                         'total_amount'          =>        $quotation->quantity * $quotation->total_price,
        //                         'order_date'            =>        Carbon::today()->toDateString(), // Correct and safe
        //                         'discount'              =>        $quotation->discount??'0',
        //                         'followed_by'           =>        $quotation->followed_by,
        //                         'payment_term'          =>        0,
        //                         'discount_type'         =>        $quotation->discount_type,
        //                         'discount_amount'       =>        $quotation->discount_amount,
        //                         'discount_percentage'   =>        $quotation->discount_percentage,
        //                         'grand_total'           =>        $quotation->grand_total,
        //                     ]);
        //                 }
        //    }
        if ($saleOrder) {
            return response()->redirectToRoute('total_order_advance.index.edit', $saleOrder->id);
        }
        return response()->redirectToRoute('quotation.index')->with('success', 'Quotation Status is Successfully Updated');
    }

    public function updateSts($id, $status)
    {
        $saleOrder = null;
        $quotation = Quotation::findOrFail($id);
        $quotation->status = $status;
        $quotation->save();
        if ($quotation->status == 'Approved') {
            $saleOrder = SaleOrder::where('quotation_id', $quotation->id)->latest()->first();
            if (is_null($saleOrder)) {
                $saleOrder =  SaleOrder::create([
                    'quotation_id'          =>        $quotation->id,
                    'status'                =>        'pending',
                    'total_amount'          =>        $quotation->quantity * $quotation->total_price,
                    'order_date'            =>        Carbon::today()->toDateString(), // Correct and safe
                    'discount'              =>        $quotation->discount ?? '0',
                    'followed_by'           =>        $quotation->followed_by,
                    'payment_term'          =>        0,
                    'discount_type'         =>        $quotation->discount_type,
                    'discount_amount'       =>        $quotation->discount_amount,
                    'discount_percentage'   =>        $quotation->discount_percentage,
                    'grand_total'           =>        $quotation->grand_total,
                ]);
            }
        }
        return $saleOrder;
    }

    /**
     * Reorder an existing quotation (create a duplicate for the customer)
     */
    public function reorder($id)
    {
        $sourceQuotation = Quotation::findOrFail($id);

        // Create a new quotation with the same details
        $newQuotation = $sourceQuotation->replicate();
        $newQuotation->status = 'Draft';

        // Generate a new reference number
        $referenceNO = Quotation::withTrashed()->count() + 1;
        $today = now();

        // Determine financial year
        $year = $today->year;
        $month = $today->month;

        if ($month >= 4) {
            // April to December
            $financialYear = $year . '-' . substr($year + 1, -2);
        } else {
            // January to March
            $financialYear = ($year - 1) . '-' . substr($year, -2);
        }

        $referenceNO = str_pad($referenceNO, 3, '0', STR_PAD_LEFT);
        $newQuotation->reference_no = 'MR/' . $referenceNO . '/' . $financialYear;
        $newQuotation->reordered_from = $sourceQuotation->id;

        $newQuotation->save();

        session()->flash('success', 'Quotation reordered successfully with new reference: ' . $newQuotation->reference_no);
        return response()->redirectToRoute('quotation.edit', ['quotation' => $newQuotation->id,'reorder'=>1]);
    }

    /**
     * Return audits (history) for a quotation as JSON.
     */
    public function audits($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Using OwenIt Auditing: $quotation->audits gives collection of audit entries
        $audits = $quotation->audits()->orderByDesc('created_at')->get();

        // Preload users referenced in audits to avoid N+1 queries
        $userIds = $audits->pluck('user_id')->filter()->unique()->values()->all();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Map audit entries to a lighter payload for frontend (include user name/email)
        $payload = $audits->map(function ($a) use ($users) {
            $userName = null;
            $userEmail = null;
            if (!empty($a->user_id) && isset($users[$a->user_id])) {
                $user = $users[$a->user_id];
                $userName = $user->name ?? null;
                $userEmail = $user->email ?? null;
            }

            return [
                'id' => $a->id,
                'event' => $a->event,
                'user_id' => $a->user_id ?? null,
                'user_name' => $userName,
                'user_email' => $userEmail,
                'user_type' => $a->user_type ?? null,
                'created_at' => $a->created_at->toDateTimeString(),
                'old_values' => $a->old_values ?? [],
                'new_values' => $a->new_values ?? [],
                'url' => $a->url ?? null,
            ];
        });

        return response()->json($payload);
    }
}
