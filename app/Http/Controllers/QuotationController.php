<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\QuotationItem;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers=Customer::all();
        $quotation=Quotation::with('customer')->get();
        return view('quotation',['customers'=>$customers,'quotation'=>$quotation]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers=Customer::where('status','active')->get(['id','name']);
        $employees=Employee::where('status','active')->get(['id','name']);
        $products=Product::where('status','active')->get(['id','name','sales_price','gst']);
        return view('new_quotation',['products'=>$products,'customers'=>$customers,'employees'=>$employees]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuotationRequest $request)
    {
        $quotation=Quotation::create([
            'customer_id'=>$request->customer_id,
            'employee_id'=>$request->employee_id,
            'remarks'=>$request->remarks,
            'tentative_dispatch_date'=>$request->tentative_dispatch_date,
            'payment_term_days'=>$request->payment_term_days,
            'customer_po_number'=>$request->customer_po_number,
            'whatsapp_number'=>$request->whatsapp_number,
        ]);
        foreach($request->srno as $key=>$value){
            QuotationItem::create([
                'quotation_id'=>$quotation->id,
                'product_id'=>$request->product_id[$key],
                'qty'=>$request->qty[$key],
                'rate'=>$request->rate[$key],
                'gst'=>$request->gst[$key],
                'discount'=>$request->discount[$key],
                'amount'=>$request->amount[$key],
            ]);
        }
        return redirect(route('quotation.index'));
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $customers=Customer::where('status','active')->get(['id','name']);
        $employees=Employee::where('status','active')->get(['id','name']);
        $products=Product::where('status','active')->where('product_type','amenities')->get(['id','name','sales_price','gst']);
        $items=$quotation->items;
        return view('new_quotation',['products'=>$products,'customers'=>$customers,'employees'=>$employees,'items'=>$items, 'quotation'=>$quotation  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
            $quotation->customer_id=$request->customer_id;
            $quotation->employee_id=$request->employee_id;
            $quotation->remarks=$request->remarks;
            $quotation->payment_term_days=$request->payment_term_days;
            $quotation->customer_po_number=$request->customer_po_number;
            $quotation->save();

            $existingItemIds = QuotationItem::where('quotation_id', $quotation->id)->pluck('id')->toArray();
            $requestItemIds = $request->item_id;
            // dd($existingItemIds,$requestItemIds);
            QuotationItem::whereIn('id', array_diff($existingItemIds,$requestItemIds))->delete();

            foreach ($request->srno as $key=>$item) {
                QuotationItem::upsert(
                    [
                        'id' => $request->item_id[$key],
                        'quotation_id' => $quotation->id,
                        'product_id' => $request->product_id[$key],
                        'qty' => $request->qty[$key],
                        'rate' => $request->rate[$key],
                        'gst' => $request->gst[$key],
                        'discount' => $request->discount[$key],
                        'amount' => $request->amount[$key],
                    ], uniqueBy: ['id'], update:['quotation_id','product_id','qty','rate','gst','discount','amount']
                );
            }
            return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        foreach($quotation->items ?? [] as $item )
        {
            $item->delete();
        }
        $quotation->delete();
        return back();
    }
}
