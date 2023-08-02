<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function administradores(){
        return $this->belongsTo(Administrador::class,'fk_admin');
    }
}
