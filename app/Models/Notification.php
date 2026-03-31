<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    public $timestamps = true; // Laravel akan handle created_at & updated_at
    
    protected $fillable = [
        'user_id',
        'tiket_id',
        'judul',
        'pesan',
        'waktu_kirim',
        'status_baca',
    ];

    protected $casts = [
        'status_baca' => 'boolean',
        'waktu_kirim' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke Tiket
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'tiket_id');
    }

    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('status_baca', false);
    }

    /**
     * Scope untuk notifikasi yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->where('status_baca', true);
    }

    /**
     * Tandai sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update(['status_baca' => true]);
    }

    /**
     * Tandai sebagai belum dibaca
     */
    public function markAsUnread()
    {
        $this->update(['status_baca' => false]);
    }

    /**
     * Cek apakah notifikasi sudah dibaca
     */
    public function isRead()
    {
        return $this->status_baca;
    }

    /**
     * Cek apakah notifikasi belum dibaca
     */
    public function isUnread()
    {
        return !$this->status_baca;
    }
}