<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'filename',
        'original_filename',
        'mime_type',
        'file_size',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getUrlAttribute(): string
    {
        return storage_path('app/public/' . $this->filename);
    }
}
