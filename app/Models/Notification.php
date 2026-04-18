<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'title',
        'messages',
        'channel',
        'status',
        'send_at',
        'sent_at',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'send_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function logs()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
