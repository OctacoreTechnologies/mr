<?php

namespace App\Http\Controllers\order_acceptance_letter;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderAcceptancLetterRequest;
use App\Models\OrderAcceptanceLetter;
use App\Models\SaleOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderAccpetanceLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SaleOrder::with('quotation', 'quotation.customer')->orderByDesc('created_at')->get();
        return response()->view('sale_orders.oal.index', [
            'salesOrders' => $salesOrders,
        ]);
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
      $oal = OrderAcceptanceLetter::where('sale_order_id',$id)->orderByDesc('created_at')->first();  
      $salesOrder = SaleOrder::findOrFail($oal->sale_order_id);
    //   return $oal; 
      return response()->view('sale_orders.oal.show',[
        'oal' => $oal,
        'saleOrder'=>$salesOrder,
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
    public function update(UpdateOrderAcceptancLetterRequest $request, string $id)
    {
        // return $request->validated();
        $validated=$request->validated();
        $orderAcceptanceLetter = OrderAcceptanceLetter::findOrFail($id);
        $orderAcceptanceLetter->update($validated);

        return response()->redirectToRoute('sale-order.index');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadOalPdf($id)
    {
        $orderAcceptance = OrderAcceptanceLetter::with('saleOrder')->where('sale_order_id',$id)->first();

        // return $orderAcceptance;
        $pdf = Pdf::loadView('sale_orders.oal.pdf', [
            'oal'=>$orderAcceptance
        ])
            ->setPaper('A4', 'portrait');

        $pdfContent = $pdf->output(); // Get binary content
       

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Order Acceptance Letter(OAL)' . $orderAcceptance->id . '.pdf"');
    }
}
