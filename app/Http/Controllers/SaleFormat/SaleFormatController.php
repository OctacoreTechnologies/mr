<?php

namespace App\Http\Controllers\SaleFormat;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SaleFormat;
use App\Http\Requests\SaleFormatRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SaleFormatController extends Controller
{
    // List all sale formats (optionally filter by customer)
    public function index(Request $request)
    {
        $query = SaleFormat::with('customer')
            ->latest();

        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $saleFormats = $query->paginate(15)->withQueryString();
        $customers   = Customer::orderBy('company_name')->get();
        

        return view('sale_formats.index', compact('saleFormats', 'customers'));
    }

    // Show create form
    public function create(Request $request)
    {
        $customers        = Customer::orderBy('company_name')->get();
        $selectedCustomer = null;
        $saleFormat       = new SaleFormat();

        if ($request->filled('customer_id')) {
            $selectedCustomer = Customer::findOrFail($request->customer_id);
        }

        return view('sale_formats.create', compact('customers', 'selectedCustomer', 'saleFormat'));
    }

    // Store new sale format
    public function store(SaleFormatRequest $request)
    {
        $validated = $request->validated();
        unset($validated['requirements']);
        $validated['sale_details'] = $this->filterSaleDetails($request->input('sale_details', []));

         if ($request->hasFile('upload_file_path')) {

            $file = $request->file('upload_file_path');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/sale_formats'), $filename);

            $validated['upload_file_path'] = 'uploads/sale_formats/' . $filename;
        }

        $saleFormat = SaleFormat::create($validated);
        $this->syncRequirements($saleFormat, $request->input('requirements', []));

        return redirect()
            ->route('sale-formats.show', $saleFormat)
            ->with('success', 'Sale Format successfully create ho gaya!');
    }

    // Show single sale format
    public function show(SaleFormat $saleFormat)
    {
        $saleFormat->load(['customer', 'requirements']);
        return view('sale_formats.show', compact('saleFormat'));
    }

    // Download PDF
    public function pdf(SaleFormat $saleFormat)
    {
        $saleFormat->load(['customer', 'requirements']);

        $pdf = Pdf::loadView('sale_formats.pdf', compact('saleFormat'))
            ->setOptions([
                'fontDir'             => public_path('fonts'),
                'fontCache'           => public_path('fonts'),
                'defaultFont'         => 'Poppins',
                'isHtml5ParserEnabled'=> true,
                'isPhpEnabled'        => true,
                'isRemoteEnabled'     => true,
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->stream('sale-format-' . $saleFormat->id . '.pdf');
    }

    // Edit form
    public function edit(SaleFormat $saleFormat)
    {
        $saleFormat->load('requirements');
        $customers = Customer::orderBy('company_name')->get();
        return view('sale_formats.edit', compact('saleFormat', 'customers'));
    }

    // Update
    public function update(SaleFormatRequest $request, SaleFormat $saleFormat)
    {
        $validated = $request->validated();
        unset($validated['requirements']);
        $validated['sale_details'] = $this->filterSaleDetails($request->input('sale_details', []));

        if ($request->hasFile('upload_file_path')) {
    
                $file = $request->file('upload_file_path');
    
                $filename = time() . '.' . $file->getClientOriginalExtension();
    
                $file->move(public_path('uploads/sale_formats'), $filename);
    
                $validated['upload_file_path'] = 'uploads/sale_formats/' . $filename;
        }

        $saleFormat->update($validated);
        $this->syncRequirements($saleFormat, $request->input('requirements', []));

        return redirect()
            ->route('sale-formats.show', $saleFormat)
            ->with('success', 'Sale Format update ho gaya!');
    }

    // Delete
    public function destroy(SaleFormat $saleFormat)
    {
        $saleFormat->delete();

        return redirect()
            ->route('sale-formats.index')
            ->with('success', 'Sale Format delete ho gaya!');
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function filterSaleDetails(array $details): array
    {
        return array_values(array_filter($details, function ($d) {
            return filled($d['application'] ?? '') || filled($d['model'] ?? '') || filled($d['output'] ?? '');
        }));
    }

    private function syncRequirements(SaleFormat $saleFormat, array $requirements): void
    {
        $saleFormat->requirements()->delete();

        $filtered = array_filter($requirements, fn($r) => filled($r));

        foreach (array_values($filtered) as $index => $desc) {
            $saleFormat->requirements()->create([
                'requirement_description' => $desc,
                'sort_order'              => $index + 1,
            ]);
        }
    }
}
