<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = "email_templates";

    
    protected $guard = ['id'];

    protected $casts = [
        'variables' => 'array'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater() {
        return $this->belongsTo(User::class, 'updated_by');
    }
    protected $guarded = ['id'];

    //   protected $casts = [
    //     'variables' => 'array',
    //     'is_active' => 'boolean',
    //     'is_marketing' => 'boolean',
    // ];

    // protected static function booted()
    // {
    //     static::creating(function ($t) {
    //         if (!$t->slug) $t->slug = Str::slug($t->name);
    //     });
    //     static::updating(function ($t) {
    //         if (!$t->slug) $t->slug = Str::slug($t->name);
    //     });
    // }

    // extract placeholders like {{customer_name}} or {{order.id}}
    // public function extractPlaceholders(): array
    // {
    //     preg_match_all('/\{\{\s*([a-zA-Z0-9_.]+)\s*\}\}/', $this->body, $matches);
    //     return array_values(array_unique($matches[1] ?? []));
    // }

    // render template with data, escaping user-supplied values
    // public function render(array $data = []): string
    // {
    //     $body = $this->body;

    //     $rendered = preg_replace_callback('/\{\{\s*([a-zA-Z0-9_.]+)\s*\}\}/', function ($m) use ($data) {
    //         $key = $m[1];
    //         $value = data_get($data, $key, '');
    //         // escape value to prevent XSS (template HTML remains intact)
    //         return e($value);
    //     }, $body);

    //     return $rendered;
    // }
}
