<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table      = 'users';
    protected $primaryKey = 'user_id'; // karena di migration kamu pakai $table->id('user_id');
    public $incrementing  = true;
    protected $keyType    = 'int';

    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id', 'user_id');
    }

    // Relasi ke tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'user_id', 'user_id');
    }

    // Relasi ke tiket yang di-assign ke user ini
    public function assignedTikets()
    {
        return $this->hasMany(Tiket::class, 'assigned_to', 'user_id');
    }

    // Relasi opsional lain
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }
}
