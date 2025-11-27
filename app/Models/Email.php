<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $guarded=[];

    public function machine(){
        return $this->belongsTo(Machine::class,'machine_id');
    }
    
    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }
}
