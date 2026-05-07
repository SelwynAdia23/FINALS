<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'course',
        'year_level',
        'department',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function ticketHistories()
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function isFaculty(): bool
    {
        return $this->hasRole('faculty');
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }

    public function isMaintenance(): bool
    {
        return $this->hasRole('maintenance');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
