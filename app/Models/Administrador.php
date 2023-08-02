<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Fundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory, HasFactory,Notifiable;
    public $timestamps = false;
    protected $fillable = [
        'email',
        'password',
    ];

    public function denuncias(){
        return $this->hasMany(Denuncia::class, 'id');
    }
}
