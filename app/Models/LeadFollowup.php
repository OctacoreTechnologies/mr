<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFollowup extends Model
{
    protected $guarded=[];

    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id');
    }
}
