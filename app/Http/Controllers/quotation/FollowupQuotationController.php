<?php

namespace App\Http\Controllers\quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowupQuotation;
use App\Http\Requests\UpdateFollowQuotationRequest;
use App\Models\Quotation;
use App\Models\QuotationFolloUp;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class FollowupQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFollowupQuotation $request)
    {
        StoreFollowupQuotation::create($request->validated());
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
        $followUpQuotation=QuotationFolloUp::find($id);
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
     * Update the specified resource in storage.
     */
    public function update(StoreFollowupQuotation $request, string $id)
    {
        $followUpQuotation=QuotationFolloUp::find($id);
        if(!empty($followUpQuotation)){
           $followUpQuotation->update($request->validated());
           return response()->json([
            'success'=>true,
            'message'=>'Follow Up Quotation is added successfully'
           ]);
        }

          return response()->json([
            'success'=>false,
            'message'=>'Not Found'
           ],200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quotationFollowUp=Quotation::findOrFail($id);
         if(!empty($quotationFollowUp)){
           $quotationFollowUp->delete();
           return response()->json([
            'success'=>true,
            'message'=>'Follow Up Quotation is added successfully'
           ],200);
        }

          return response()->json([
            'success'=>false,
            'message'=>'Not Found'
           ],200);

    }

    public function followUpQuotationEdit(string $quotationId){
        $quotationFollowUps=QuotationFolloUp::where('quotation_id',$quotationId)->get();
       
        return response()->view('followups.edit',[
            'followups'=>$quotationFollowUps,
            'quotation_id'=>$quotationId,
        ]);
    }

    public function followUpQuotationStore(UpdateFollowQuotationRequest $request,string $quotationId){
         $validated=$request->validated();
         $previousFollowUps=QuotationFolloUp::where('quotation_id',$quotationId)->get();

         foreach($previousFollowUps as $previousFollowUp){
            if (!in_array($previousFollowUp->id, $validated['follow_up_id'])) {
                $previousFollowUp->delete();
            }
         }

         foreach($validated['follow_date'] as $index=>$followDate){
            if(is_null($validated['follow_up_id'][$index])){
              QuotationFolloUp::create([
                'quotation_id'=>$quotationId,
                'follow_date'=>$validated['follow_date'][$index],
                'notes'=>$validated['notes'][$index]
              ]);
            }
            else{
                $quotationFollowUp=QuotationFolloUp::findOrFail($validated['follow_up_id'][$index]);
                $quotationFollowUp->update([
                    'follow_date'=>$validated['follow_date'][$index],
                    'notes'=>$validated['notes'][$index]
                ]);
            }
         }

         return redirect()->back()->with('success','Quotation Follow Updated successfully');
    }


}
