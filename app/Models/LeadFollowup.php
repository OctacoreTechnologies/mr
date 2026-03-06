<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class LeadFollowup extends Model
{
    use LogsUserActivity;
    protected $guarded=[];

    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id');
    }
}
