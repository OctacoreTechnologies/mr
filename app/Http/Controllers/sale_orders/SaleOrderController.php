<?php

namespace App\Http\Controllers\sale_orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleOrderStoreRequest;
use App\Http\Requests\SaleOrderUpdateRequest;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\SaleLedger;
use App\Models\SaleOrder;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SaleOrder::with('quotation', 'quotation.customer')->orderByDesc('created_at')->get();
        return response()->view('sale_orders.index', [
            'salesOrders' => $salesOrders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quotations = Quotation::orderByDesc('updated_at')->get();

        return response()->view('sale_orders.create', [
            'quotations' => $quotations,
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleOrderStoreRequest $request)
    {
        $validated = $request->validated();
        // return $validated;
        DB::beginTransaction();

        try {
            // Create SaleOrder
            $saleOrder = SaleOrder::create([
                'quotation_id' => $validated['quotation_id'],
                'order_date' => $validated['order_date'],
                'delivery_date' => $validated['delivery_date'],
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'total_amount' => $validated['total_amount'],
                'tax' => $validated['tax'],
                'discount' => $validated['discount'],
                'grand_total' => $validated['grand_total'],
                'remarks' => $validated['remarks'],
                'followed_by' => $validated['followed_by'],
                'payment_term' => $validated['payment_term'],
            ]);

            foreach ($validated['payments'] as $payment) {
                SaleLedger::create([
                    'sale_order_id' => $saleOrder->id,
                    'payment_date' => $payment['date'],
                    'amount' => $payment['amount'],
                    'mode' => $payment['mode'],
                    'transaction_id' => $payment['mode'] === 'online' ? $payment['transaction_id'] : null,
                    'remarks' => $payment['mode'] === 'other' ? $payment['remarks'] : null,
                ]);
            }

            DB::commit();

            return redirect()->route('sale-order.index')->with('success', 'Sale order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log or handle error as needed
            return back()->withErrors('Something went wrong while saving the sale order.' . $e)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $saleOrder = SaleOrder::with('payments', 'quotation', 'quotation.customer')->findOrFail($id);
        $totalLedgerAmount = $saleOrder->payments->where('type', 'after')->sum('amount');
        $advancePayment = $saleOrder->payments->where('type', 'before')->sum('amount');
        $grandTotal = $saleOrder->grand_total ?? 0;

        $totalPaid = $totalLedgerAmount + $advancePayment;
        $pendingAmount = $grandTotal - $totalPaid;

        return response()->view('sale_orders.show', [
            'saleOrder' => $saleOrder,
            'totalLedgerAmount' => $totalLedgerAmount,
            'advancePayment' => $advancePayment ?? '0s',
            'pendingAmount' => $pendingAmount,
            'grandTotal' => $grandTotal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $saleOrder = SaleOrder::with(['quotation', 'quotation.customer', 'quotation.machine', 'quotation.modele'])->findOrFail($id);

        return response()->view('sale_orders.edit', [
            'quotations' => Quotation::orderByDesc('created_at')->get(),
            'saleOrder' => $saleOrder,
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleOrderUpdateRequest $request, SaleOrder $saleOrder)
    {
        $validated = $request->validated();
        DB::beginTransaction();

        try {
            if ($saleOrder->po_no != $validated['po_no'] && !is_null($validated['po_no'])) {
                $customer = Customer::findOrFail($saleOrder->quotation->customer_id);
                $customer->update([
                    'po_no' => $validated['po_no']
                ]);
            }
            $saleOrder->update([
                'quotation_id' => $validated['quotation_id'],
                // 'order_date' => $validated['order_date'],
                'delivery_date' => $validated['delivery_date'],
                'status' => $validated['status'],
                // 'payment_status' => $validated['payment_status'],
                'transporation_payment' => $validated['transporation_payment'],
                'total_amount' => $validated['total_amount'],
                'tax' => $validated['tax'],
                'discount_type' => $validated['discount_type'],
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'discount_percentage' => $validated['discount_percentage'] ?? 0,
                'insurance' => $validated['insurance'],
                'packging' => $validated['packging'],
                'grand_total' => $validated['grand_total'],
                'remarks' => $validated['remarks'],
                'followed_by' => $validated['followed_by'],
                'payment_term' => $validated['payment_term'],
                'payment_term_condition' => $validated['payment_term_condition'],
                'advanace_payment' => $validated['advanace_payment'],
                // 'advance_payment_date' => $validated['advance_payment_date'],
                'po_no' => $validated['po_no'],
                'transporation_charge' => $validated['transporation_charge'],
                // 'address' => $validated['address'],
            ]);

            SaleLedger::where('sale_order_id', $saleOrder->id)->delete();

            if (isset($validated['payments']) && $validated['payments'] != null) {
                foreach ($validated['payments'] as $payment) {
                    SaleLedger::create([
                        'sale_order_id' => $saleOrder->id, // ✅ Should work now
                        'type' => $payment['type'],
                        'payment_date' => $payment['date'],
                        'amount' => $payment['amount'],
                        'mode' => $payment['mode'],
                        'transaction_id' => $payment['mode'] === 'online' ? $payment['transaction_id'] : null,
                        'remarks' => $payment['mode'] === 'other' ? $payment['remarks'] : null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('order-acceptence-letter.edit', $saleOrder->id)->with('success', 'Sale order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $saleOrder = SaleOrder::findOrFail($id);
        $saleOrder->delete();
        return response()->redirectToRoute('sale-order.index')->with('success', 'Sale Order is Removed Successfully');
    }

    public function pdf(string $id)
    {
        $saleOrder = SaleOrder::findOrFail($id);



        // return response()->view('sale_orders.pdf',[
        //     'saleOrder' => $saleOrder,
        // ]);
        $pdf = Pdf::loadView('sale_orders.pdf', [
            'saleOrder' => $saleOrder,
        ])
            ->setOptions([
                'fontDir' => public_path('fonts'),  // Path to custom fonts
                'fontCache' => public_path('fonts'),  // Cache for fonts
                'defaultFont' => 'Poppins',  // Default font
                'isHtml5ParserEnabled' => true,  // Enable HTML5 parsing
                'isPhpEnabled' => true,  // Allow PHP functions (if needed)
            ]);
        return $pdf->stream('invoice_' . $saleOrder->id . 'pdf');
    }

    public function downloadAccountPdf($id)
    {
        $saleOrder = SaleOrder::with(['quotation.customer', 'quotation.machine', 'quotation.modele'])->findOrFail($id);

        $pdf = Pdf::loadView('sale_orders.account_details', compact('saleOrder'))
            ->setPaper('A4', 'portrait');

        $pdfContent = $pdf->output(); // Get binary content

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Customer_Account_Details_' . $saleOrder->id . '.pdf"');
    }

    public function downloadAdvancePaymentPdf($id)
    {
        $saleOrder = SaleOrder::with(['quotation.customer', 'quotation.machine', 'quotation.modele'])->findOrFail($id);
        $pdf = PDF::loadView('sale_orders.advance_payment', [
            'saleOrder' => $saleOrder,
        ])
            ->setOptions([
                'fontDir' => public_path('/fonts'),
                'fontCache' => public_path('/fonts'),
                'defaultFont' => 'Poppins',
                'isFontSubsettingEnabled' => false,
                'isHtml5ParserEnabled' => true,
            ]);
        

        return $pdf->stream('advance-payment.pdf');
    }

    public function getAccountDetails($id)
    {
        $saleOrder = SaleOrder::with(['quotation.customer', 'quotation.machine', 'quotation.modele', 'payments'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $saleOrder,
        ]);
    }

    /**
     * Return sale orders for a given customer (used by AJAX in opportunity create view)
     */
    public function saleOrdersByCustomer($customerId)
    {
        $saleOrders = SaleOrder::with(['quotation', 'quotation.machine', 'quotation.application'])->whereHas('quotation', function ($q) use ($customerId) {
            $q->where('customer_id', $customerId);
        })->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'data' => $saleOrders,
        ]);
    }

    /**
     * Return quotations for a given customer (used by AJAX in opportunity create view)
     */
    public function quotationsByCustomer($customerId)
    {
        $quotations = Quotation::with(['machine', 'application'])->where('customer_id', $customerId)->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'data' => $quotations,
        ]);
    }

    // advance index
    public function advanceIndex()
    {
        $salesOrders = SaleOrder::with('quotation', 'quotation.customer')->orderByDesc('created_at')->get();
        return response()->view('sale_orders.advance_payment_letters.index', [
            'salesOrders' => $salesOrders,
        ]);
    }

    public function advancePaymentEdit(string $id)
    {

        $saleOrder = SaleOrder::with(['quotation', 'quotation.customer', 'quotation.machine', 'quotation.modele'])->findOrFail($id);

        return response()->view('sale_orders.advance_payment_letters.edit', [
            'quotations' => Quotation::orderByDesc('created_at')->get(),
            'saleOrder' => $saleOrder,
            'users' => User::all(),
        ]);
    }
}
