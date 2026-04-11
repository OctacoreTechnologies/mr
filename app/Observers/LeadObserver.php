<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function saved(Lead $lead): void
    {
        // if ($lead->status === 'qualified') {
        //     Opportunity::create(
        //         [   'customer_id' => $lead->id,
        //             'type' => 'new_enquiry',
        //             'followed_by' => $lead->followed_by,
        //             'created_by' => Auth::id(),
        //         ]
        //     );
        // }
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
