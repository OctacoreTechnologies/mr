<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use HasFactory,SoftDeletes,LogsUserActivity;

    protected $guarded=['id'];

}
