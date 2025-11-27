<?php

namespace App\Http\Controllers\lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadFollowUpRequest;
use App\Models\LeadFollowup;
use Illuminate\Http\Request;

class LeadFollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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

      public function followUpQuotationEdit(string $leadId){
        $quotationFollowUps=LeadFollowup::where('lead_id',$leadId)->get();
       
        return response()->view('leads.followup.edit',[
            'followups'=>$quotationFollowUps,
            'lead_id'=>$leadId,
        ]);
       }

        public function followUpQuotationStore(LeadFollowUpRequest $request,string $quotationId){
         $validated=$request->validated();
         $previousFollowUps=LeadFollowup::where('lead_id',$quotationId)->get();

         foreach($previousFollowUps as $previousFollowUp){
            if (!in_array($previousFollowUp->id, $validated['follow_up_id'])) {
                $previousFollowUp->delete();
            }
         }

         foreach($validated['followup_date'] as $index=>$followDate){
            if(is_null($validated['follow_up_id'][$index])){
              LeadFollowup::create([
                'lead_id'=>$quotationId,
                'followup_date'=>$validated['followup_date'][$index],
                'notes'=>$validated['notes'][$index]
              ]);
            }
            else{
                $quotationFollowUp=LeadFollowup::findOrFail($validated['follow_up_id'][$index]);
                $quotationFollowUp->update([
                    'followup_date'=>$validated['followup_date'][$index],
                    'notes'=>$validated['notes'][$index]
                ]);
            }
         }

         return redirect()->back()->with('success','Lead Follow Updated successfully');
    }
}
