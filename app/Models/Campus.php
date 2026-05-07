<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
