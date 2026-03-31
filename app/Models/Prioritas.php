<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioritas extends Model
{
    protected $table = 'priorities'; // nama tabel
    protected $primaryKey = 'prioritas_id'; // primary key sesuai migration
    public $incrementing = true;

    protected $fillable = [
        'nama_prioritas',
    ];

    // Relasi ke tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'prioritas_id');
    }
}
