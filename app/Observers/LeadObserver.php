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
        $opportunity=Opportunity::where('lead_id',$lead->id)->first();
        if($lead->status=='qualified'&&is_null($opportunity)){
            Opportunity::create([
                'lead_id'=>$lead->id,
                'name'=>$lead->full_name,
                'stage'=>'qualification',
                'followed_by'=>$lead->followed_by,
                // 'created_by'=>Auth::user()->id,
            ]);
        }
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
