<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table      = 'roles';   
    protected $primaryKey = 'role_id'; 
    public $incrementing  = true;
    protected $keyType    = 'int';

    protected $fillable = ['nama_role', 'deskripsi'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
