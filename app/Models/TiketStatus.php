<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketStatus extends Model
{

    protected $table      = 'tiket_statuses';
    protected $primaryKey = 'status_id'; // ganti sesuai kolom di DB
    public $incrementing  = true;

    protected $fillable = [
        'nama_status',
    ];

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class, 'status_id', 'status_id');
    }
}
