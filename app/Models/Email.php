<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use LogsUserActivity;
    protected $guarded=[];

    public function machine(){
        return $this->belongsTo(Machine::class,'machine_id');
    }
    
    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }
}
