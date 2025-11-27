<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerFollowUpRequest;
use App\Http\Requests\UpdateCustomerFollowUpRequest;
use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerFollowUpController extends Controller
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
    public function store(StoreCustomerFollowUpRequest $request)
    {
        CustomerFollowUp::create($request->validated());
        return response()->json([
            'status'=>true,
            'message'=>'Follow Up Quotation is  added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $followUpQuotation=CustomerFollowUp::find($id);
        if(!empty($followUpQuotation)){
            return response()->json([
                'status'=>true
            ]);
        }
          return response()->json([
                'status'=>false,
                'message'=>'Not Found'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

        public function CustomerfollowUpEdit(string $customerId){
        $quotationFollowUps=CustomerFollowUp::where('customer_id',$customerId);
       
        return response()->view('followups.edit',[
            'followups'=>$quotationFollowUps->get(),
            'ofollowups' => $quotationFollowUps->orderByDesc('created_at')->get(),
            'customer_id'=>$customerId, 
        ]);
    }

  public function CustomerfollowUpStore(UpdateCustomerFollowUpRequest $request, string $customerId)
{
    $validated = $request->validated();
    $previousFollowUps = CustomerFollowUp::where('customer_id', $customerId)->get();

    // Delete followups not present in the form
    foreach ($previousFollowUps as $previousFollowUp) {
        if (!in_array($previousFollowUp->id, $validated['follow_up_id'])) {
            // Also delete old reminders
            Reminder::where([
                ['type_id', '=', $customerId],
                ['type', '=', 'quotation followup'],
                ['model', '=', 'Customer'],
                ['sent_date', '=', $previousFollowUp->next_follow_up_date],
            ])->delete();

            $previousFollowUp->delete();
        }
    }

    // Loop over followups
    foreach ($validated['follow_up_date'] as $index => $followDate) {
            $nextDate = $validated['next_follow_up_date'][$index] ?? null;
            if ($nextDate) {
                try {
                    // Convert from 12-hour AM/PM format to 24-hour MySQL datetime
                    $nextDate = Carbon::createFromFormat('Y-m-d h:i A', $nextDate)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    // Fallback or log error if parsing fails
                    $nextDate = null;
                }
            } else {
                $convernextDatetedDate = null;
            }


        if (is_null($validated['follow_up_id'][$index])) {
            // New follow-up
            CustomerFollowUp::create([
                'customer_id' => $customerId,
                'follow_up_date' => $followDate,
                'notes' => $validated['notes'][$index],
                'next_follow_up_date' => $nextDate,
            ]);

            if (!is_null($nextDate)) {
                Reminder::create([
                    'type_id' => $customerId,
                    'type' => 'quotation followup',
                    'data' => 'Customer Quotation Followup',
                    'model' => 'Customer',
                    'sent_date' => $nextDate,
                ]);
            }
        } else {
            // Existing follow-up
            $followUp = CustomerFollowUp::findOrFail($validated['follow_up_id'][$index]);

            $oldDate = $followUp->next_follow_up_date;

            $followUp->update([
                'follow_up_date' => $followDate,
                'notes' => $validated['notes'][$index],
                'next_follow_up_date' => $nextDate,
            ]);

            if ($oldDate != $nextDate) {
                // Delete old reminder
                Reminder::where([
                    ['type_id', '=', $customerId],
                    ['type', '=', 'quotation followup'],
                    ['model', '=', 'Customer'],
                    ['sent_date', '=', $oldDate],
                ])->delete();

                // Create new reminder
                if (!is_null($nextDate)) {
                    Reminder::create([
                        'type_id' => $customerId,
                        'type' => 'quotation followup',
                        'data' => 'Customer Quotation Followup',
                        'model' => 'Customer',
                        'sent_date' => $nextDate,
                    ]);
                }
            }
        }
    }

    return redirect()->back()->with('success', 'Quotation Follow-Up updated successfully.');
}

public function customerFollowUp(string $customerId){
    $customerFollowUps=CustomerFollowUp::where('customer_id',$customerId)->get();
    // return $customerFollowUps;
    $customer = Customer::findOrFail($customerId);
    return response()->view('followups.show',[
        'followups'=>$customerFollowUps,
        'customer'=>$customer
    ]);
}

}
