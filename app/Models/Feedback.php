<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'tiket_id',
        'user_id',
        'rating',
        'komentar',
    ];

    public function tikets()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
