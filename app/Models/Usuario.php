<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    //Para acceder a cuenta desde Usuario
    public function cuenta(){
        return $this->hasOne(Cuenta::class, 'idUsuario');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'idUsuario');
    }

    public function seguidos(){
        return $this->belongsToMany(Usuario::class, 'followers', 'idSeguidor', 'idSeguido');
    }

    public function seguidores(){
        return $this->belongsToMany(Usuario::class, 'followers', 'idSeguido', 'idSeguidor');
    }

}
