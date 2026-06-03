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
            ->withCount('requirements')
            ->latest();

        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        $saleFormats = $query->get();
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
        unset($validated['requirements'], $validated['person_documents'], $validated['person_existing_docs']);
        $validated['sale_details']    = $this->filterSaleDetails($request->input('sale_details', []));
        $rawPersons = $this->mergePersonDocuments($request->input('contact_persons', []), $request);
        $cp = $this->filterContactPersons($rawPersons);
        $validated['contact_persons'] = !empty($cp) ? $cp : null;

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
        unset($validated['requirements'], $validated['person_documents'], $validated['person_existing_docs']);
        $validated['sale_details'] = $this->filterSaleDetails($request->input('sale_details', []));
        $rawPersons2 = $this->mergePersonDocuments($request->input('contact_persons', []), $request);
        $cp2 = $this->filterContactPersons($rawPersons2);
        $validated['contact_persons'] = !empty($cp2) ? $cp2 : null;
        $validated['upload_file_path'] = null;

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

    private function mergePersonDocuments(array $persons, Request $request): array
    {
        $existingDocs = $request->input('person_existing_docs', []);
        $uploadedDocs = $request->file('person_documents', []);

        foreach ($persons as $i => &$person) {
            $docs = array_values(array_filter((array) ($existingDocs[$i] ?? []), fn($d) => filled($d)));
            foreach ((array) ($uploadedDocs[$i] ?? []) as $file) {
                if ($file && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/sale_formats'), $filename);
                    $docs[] = 'uploads/sale_formats/' . $filename;
                }
            }
            $person['documents'] = $docs;
        }
        unset($person);
        return $persons;
    }

    private function filterContactPersons(array $persons): array
    {
        $result = [];
        foreach ($persons as $p) {
            $contacts = array_values(array_filter($p['contact']   ?? [], fn($c) => filled($c)));
            $emails   = array_values(array_filter($p['email']     ?? [], fn($e) => filled($e)));
            $docs     = array_values(array_filter($p['documents'] ?? [], fn($d) => filled($d)));
            if (filled($p['name'] ?? '') || filled($p['designation'] ?? '') || !empty($contacts) || !empty($emails) || !empty($docs)) {
                $result[] = [
                    'name'        => $p['name']        ?? '',
                    'designation' => $p['designation'] ?? '',
                    'contact'     => $contacts,
                    'email'       => $emails,
                    'documents'   => $docs,
                ];
            }
        }
        return $result;
    }

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
