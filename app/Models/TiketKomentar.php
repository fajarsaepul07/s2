<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketKomentar extends Model
{
    use HasFactory;

    protected $table      = 'tiket_komentars';
    protected $primaryKey = 'komentar_id';

    protected $fillable = [
        'tiket_id',
        'user_id',
        'komentar',
        'rating',
        'tipe_komentar',
        'waktu_komentar',
    ];

    protected $casts = [
        'waktu_komentar' => 'datetime',
        'rating'         => 'integer',
    ];

    /**
     * Relasi ke Tiket
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'tiket_id');
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
