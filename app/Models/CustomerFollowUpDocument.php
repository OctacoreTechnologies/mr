<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CustomerFollowUpDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'follow_up_id',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by',
    ];

    /* ── Relationship ── */

    public function followUp(): BelongsTo
    {
        return $this->belongsTo(CustomerFollowUp::class, 'follow_up_id');
    }

    /* ── Accessors ── */

    /** Full URL for download/preview */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /** Human-readable file size (KB / MB) */
    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1_048_576) {
            return round($bytes / 1_048_576, 2) . ' MB';
        }
        return round($bytes / 1_024, 1) . ' KB';
    }

    /** Icon class based on file_type */
    public function getIconClassAttribute(): string
    {
        return match (strtolower($this->file_type)) {
            'pdf'                     => 'fas fa-file-pdf text-danger',
            'xls', 'xlsx', 'csv'      => 'fas fa-file-excel text-success',
            'doc', 'docx'             => 'fas fa-file-word text-primary',
            'jpg', 'jpeg', 'png',
            'gif', 'webp', 'svg'      => 'fas fa-file-image text-warning',
            'zip', 'rar', '7z'        => 'fas fa-file-archive text-secondary',
            default                   => 'fas fa-file text-muted',
        };
    }

    /** Is this an image? */
    public function getIsImageAttribute(): bool
    {
        return in_array(strtolower($this->file_type), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }
}