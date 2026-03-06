<?php

namespace App\Models;

use App\LogsUserActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory,LogsUserActivity;

    protected $guarded=['id'];
    
}
