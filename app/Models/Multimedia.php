<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Multimedia extends Model
{
    use HasFactory;

    public function posts(){
        return $this->hasMany(Post::class, 'idMultimedia');
    }

    public function cuenta(){
        return $this->hasOne(Cuenta::class, 'idMultimedia');
    }

}
