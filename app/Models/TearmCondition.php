<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TearmCondition extends Model
{
    use SoftDeletes,LogsUserActivity;
    protected $guarded=['id'];
}
