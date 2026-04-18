<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerFollowUpRequest;
use App\Http\Requests\UpdateCustomerFollowUpRequest;
use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\CustomerFollowUpDocument;
use App\Models\Notification;
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
        $followUp = CustomerFollowUp::create($request->validated());

        if (!is_null($followUp->next_follow_up_date)) {

            $type   = in_array($request->query('type'), ['opportunity', 'quotation'])
                ? $request->query('type')
                : 'customer';

            $typeId = match ($type) {
                'opportunity' => $followUp->opportunity_id,
                'quotation'   => $followUp->quotation_id,
                default       => null,
            };

            $this->createNotifications(
                $followUp->customer_id,
                $followUp->next_follow_up_date,
                ['type' => $type, 'type_id' => $typeId]
            );
        }

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

        // URL type context
        $type = $validated['type']??'customer';

        // $type = in_array($type, ['opportunity', 'quotation'])
        //                ? $type
        //                : 'customer';

        $typeId = match ($type) {
            'opportunity' => $validated['opportunity_id'] ?? null,
            'quotation'   => $validated['quotation_id']   ?? null,
             default       => null,
        };

        $context = ['type' => $type, 'type_id' => $typeId];

        DB::beginTransaction();
        try {

            /* ── 1. Delete marked documents ── */
            if (!empty($validated['delete_document_ids'])) {
                $docsToDelete = CustomerFollowUpDocument::whereIn('id', $validated['delete_document_ids'])->get();
                foreach ($docsToDelete as $doc) {
                    Storage::disk('public')->delete($doc->file_path);
                    $doc->delete();
                }
            }

            /* ── 2. Delete removed follow-up rows ── */
            $submittedIds      = array_filter($validated['follow_up_id'] ?? [], fn($v) => !is_null($v));
            $previousFollowUps = CustomerFollowUp::where('customer_id', $customerId)->get();

            foreach ($previousFollowUps as $prev) {
                if (!in_array($prev->id, $submittedIds)) {
                    foreach ($prev->documents as $doc) {
                        Storage::disk('public')->delete($doc->file_path);
                    }

                    // ── Notification delete (jo is follow-up ke liye bani thi) ──
                    Notification::where('notifiable_id', $customerId)
                        ->where('notifiable_type', Customer::class)
                        ->where('send_at', $prev->next_follow_up_date)
                        ->where('status', 'pending')
                        ->whereJsonContains('meta->type', $context['type'])
                        ->delete();

                    $prev->delete();
                }
            }

            /* ── 3. Upsert follow-up rows ── */
            foreach ($validated['follow_up_date'] as $index => $followDate) {

                $rawNext          = $validated['next_follow_up_date'][$index] ?? null;
                $nextDate         = $this->parseDate($rawNext);
                $followDateParsed = $this->parseDate($followDate);
                $isNew            = is_null($validated['follow_up_id'][$index]);

                if ($isNew) {
                    $followUp = CustomerFollowUp::create([
                        'customer_id'        => $customerId,
                        'quotation_id'       => $validated['quotation_id']   ?? null,
                        'opportunity_id'     => $validated['opportunity_id'] ?? null,
                        'follow_up_date'     => $followDateParsed,
                        'notes'              => $validated['notes'][$index],
                        'next_follow_up_date' => $nextDate,
                    ]);

                    if (!is_null($nextDate)) {
                        $this->createNotifications($customerId, $nextDate, $context);
                    }
                } else {
                    $followUp = CustomerFollowUp::findOrFail($validated['follow_up_id'][$index]);
                    $oldDate  = $followUp->next_follow_up_date;

                    $followUp->update([
                        'follow_up_date'      => $followDateParsed,
                        'notes'               => $validated['notes'][$index],
                        'next_follow_up_date' => $nextDate,
                    ]);

                    // Date change hone par purani notifications delete, nayi banao
                    if ($oldDate != $nextDate) {
                        Notification::where('notifiable_id', $customerId)
                            ->where('notifiable_type', Customer::class)
                            ->where('send_at', $oldDate)
                            ->where('status', 'pending')
                            ->whereJsonContains('meta->type', $context['type'])
                            ->delete();

                        if (!is_null($nextDate)) {
                            $this->createNotifications($customerId, $nextDate, $context);
                        }
                    }
                }

                /* ── 4. Upload documents ── */
                $newFiles = $request->file("documents.{$index}") ?? [];
                foreach ($newFiles as $file) {
                    if (!$file || !$file->isValid()) continue;

                    $ext  = strtolower($file->getClientOriginalExtension());
                    $path = $file->store("followup_documents/{$customerId}/{$followUp->id}", 'public');

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
                ->with('error', "Something went wrong. Please try again.");
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
            } catch (\Exception) {
            }
        }
        return null;
    }

    /** Create a reminder record */
    private function createNotifications(string $customerId, string $sendAt, array $context): void
    {
        $customer = Customer::select('company_name', 'contact_person_1_email', 'contact_person_1_contact')
            ->where('id', $customerId)
            ->first();

        $title   = 'Follow-up Reminder';
        $message = "Follow up with {$customer->company_name}";

        $channels = ['system', 'email', 'whatsapp'];

        foreach ($channels as $channel) {
            Notification::create([
                'notifiable_id'   => $customerId,
                'notifiable_type' => Customer::class,
                'title'           => $title,
                'messages'         => $message,
                'channel'         => $channel,
                'status'          => 'pending',
                'send_at'         => $sendAt,
                'meta'            => [
                    'type'           => $context['type'],          // 'customer' | 'opportunity' | 'quotation'
                    'type_id'        => $context['type_id'],       // opportunity_id / quotation_id / null
                    'customer_id'    => $customerId,
                    'email'          => $customer->contact_person_1_email ?? null,
                    'phone'          => $customer->contact_person_1_contact ?? null,
                ],
            ]);
        }
    }
}
