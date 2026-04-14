<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerFollowUpRequest;
use App\Http\Requests\UpdateCustomerFollowUpRequest;
use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\CustomerFollowUpDocument;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomerFollowUpController extends Controller
{
    /* ────────────────────────────────────────────
     |  STORE  (quick AJAX from quotation page)
     ──────────────────────────────────────────── */
    public function store(StoreCustomerFollowUpRequest $request)
    {
        CustomerFollowUp::create($request->validated());
        return response()->json([
            'status'  => true,
            'message' => 'Follow-up added successfully.',
        ]);
    }

    /* ────────────────────────────────────────────
     |  SHOW  (check existence – AJAX)
     ──────────────────────────────────────────── */
    public function show(string $id)
    {
        $exists = CustomerFollowUp::find($id);
        return response()->json(['status' => (bool) $exists]);
    }

    /* ────────────────────────────────────────────
     |  EDIT  (render follow-up edit page)
     ──────────────────────────────────────────── */
    public function CustomerfollowUpEdit(Request $request, string $customerId)
    {
        $query = CustomerFollowUp::where('customer_id', $customerId)
                                 ->with('documents');

        if ($request->filled('quotation_id')) {
            $query->where('quotation_id', $request->query('quotation_id'));
        }

        // History = all records (oldest first for timeline)
        $followups  = (clone $query)->orderBy('created_at')->get();

        // Editable rows = same records newest first
        $ofollowups = (clone $query)->orderByDesc('created_at')->get();

        return view('followups.edit', [
            'followups'   => $followups,
            'ofollowups'  => $ofollowups,
            'customer_id' => $customerId,
        ]);
    }

    /* ────────────────────────────────────────────
     |  UPDATE  (save all follow-up rows + docs)
     ──────────────────────────────────────────── */
    public function CustomerfollowUpStore(UpdateCustomerFollowUpRequest $request, string $customerId)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            /* ── 1. Delete documents explicitly marked for removal ── */
            if (!empty($validated['delete_document_ids'])) {
                $docsToDelete = CustomerFollowUpDocument::whereIn('id', $validated['delete_document_ids'])->get();
                foreach ($docsToDelete as $doc) {
                    Storage::disk('public')->delete($doc->file_path);
                    $doc->delete();
                }
            }

            /* ── 2. Delete follow-up rows that were removed from form ── */
            $submittedIds      = array_filter($validated['follow_up_id'] ?? [], fn($v) => !is_null($v));
            $previousFollowUps = CustomerFollowUp::where('customer_id', $customerId)->get();

            foreach ($previousFollowUps as $prev) {
                if (!in_array($prev->id, $submittedIds)) {
                    // Delete all documents for this follow-up
                    foreach ($prev->documents as $doc) {
                        Storage::disk('public')->delete($doc->file_path);
                    }
                    // Delete related reminders
                    Reminder::where([
                        ['type_id', '=', $customerId],
                        ['type',    '=', 'quotation followup'],
                        ['model',   '=', 'Customer'],
                        ['sent_date', '=', $prev->next_follow_up_date],
                    ])->delete();

                    $prev->delete();
                }
            }

            /* ── 3. Upsert follow-up rows ── */
            foreach ($validated['follow_up_date'] as $index => $followDate) {

                // Parse next follow-up date (12-hr AM/PM → MySQL)
                $rawNext  = $validated['next_follow_up_date'][$index] ?? null;
                $nextDate = $this->parseDate($rawNext);
                $followDateParsed = $this->parseDate($followDate);

                $isNew = is_null($validated['follow_up_id'][$index]);

                if ($isNew) {
                    /* ── Create new follow-up ── */
                    $followUp = CustomerFollowUp::create([
                        'customer_id'        => $customerId,
                        'quotation_id'       => $validated['quotation_id'] ?? null,
                        'follow_up_date'     => $followDateParsed,
                        'notes'              => $validated['notes'][$index],
                        'next_follow_up_date' => $nextDate,
                    ]);

                    if (!is_null($nextDate)) {
                        $this->createReminder($customerId, $nextDate);
                    }
                } else {
                    /* ── Update existing follow-up ── */
                    $followUp = CustomerFollowUp::findOrFail($validated['follow_up_id'][$index]);
                    $oldDate  = $followUp->next_follow_up_date;

                    $followUp->update([
                        'follow_up_date'      => $followDateParsed,
                        'notes'               => $validated['notes'][$index],
                        'next_follow_up_date' => $nextDate,
                    ]);

                    // Sync reminder if date changed
                    if ($oldDate != $nextDate) {
                        Reminder::where([
                            ['type_id',   '=', $customerId],
                            ['type',      '=', 'quotation followup'],
                            ['model',     '=', 'Customer'],
                            ['sent_date', '=', $oldDate],
                        ])->delete();

                        if (!is_null($nextDate)) {
                            $this->createReminder($customerId, $nextDate);
                        }
                    }
                }

                /* ── 4. Upload new documents for this row ── */
                $newFiles = $request->file("documents.{$index}") ?? [];
                foreach ($newFiles as $file) {
                    if (!$file || !$file->isValid()) continue;

                    $ext      = strtolower($file->getClientOriginalExtension());
                    $path     = $file->store("followup_documents/{$customerId}/{$followUp->id}", 'public');

                    CustomerFollowUpDocument::create([
                        'follow_up_id'  => $followUp->id,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path'     => $path,
                        'file_type'     => $ext,
                        'file_size'     => $file->getSize(),
                        'uploaded_by'   => Auth::id(),
                    ]);
                }
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CustomerFollowUp update failed', ['error' => $e->getMessage()]);
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->back()->with('success', 'Follow-up updated successfully.');
    }

    /* ────────────────────────────────────────────
     |  DELETE DOCUMENT  (AJAX)
     ──────────────────────────────────────────── */
    public function deleteDocument(Request $request, int $docId)
    {
        $doc = CustomerFollowUpDocument::findOrFail($docId);
        Storage::disk('public')->delete($doc->file_path);
        $doc->delete();

        return response()->json(['status' => true, 'message' => 'Document deleted.']);
    }

    /* ────────────────────────────────────────────
     |  SHOW (customer follow-up list page)
     ──────────────────────────────────────────── */
    public function customerFollowUp(string $customerId)
    {
        $customer    = Customer::findOrFail($customerId);
        $followUps   = CustomerFollowUp::where('customer_id', $customerId)
                                       ->with('documents')
                                       ->orderByDesc('created_at')
                                       ->get();

        return view('followups.show', [
            'followups' => $followUps,
            'customer'  => $customer,
        ]);
    }

    /* ────────────────────────────────────────────
     |  HELPERS
     ──────────────────────────────────────────── */

    /** Parse date string from flatpickr (12-hr AM/PM) safely */
    private function parseDate(?string $date): ?string
    {
        if (!$date) return null;

        $formats = ['Y-m-d h:i A', 'Y-m-d H:i:s', 'Y-m-d H:i'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($date))->format('Y-m-d H:i:s');
            } catch (\Exception) {}
        }
        return null;
    }

    /** Create a reminder record */
    private function createReminder(string $customerId, string $sentDate): void
    {
        Reminder::create([
            'type_id'   => $customerId,
            'type'      => 'quotation followup',
            'data'      => 'Customer Quotation Followup',
            'model'     => 'Customer',
            'sent_date' => $sentDate,
        ]);
    }
}