<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes,LogsUserActivity;
    protected $guarded=[];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
