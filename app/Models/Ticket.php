<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'campus_id',
        'category_id',
        'subject',
        'description',
        'priority',
        'status',
        'assigned_to',
        'resolution',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function histories()
    {
        return $this->hasMany(TicketHistory::class)->latest();
    }

    public static function generateTicketNumber(): string
    {
        $date = now()->format('Ymd');
        $lastTicket = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastTicket ? ((int) substr($lastTicket->ticket_number, -4)) + 1 : 1;

        return 'CC-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
