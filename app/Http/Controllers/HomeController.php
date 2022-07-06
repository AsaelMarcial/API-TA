<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Usuario;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function buscarUsuario(string $username){
        $usuario=Usuario::where('username', $username)->first();
        return $usuario;
    }

    public function mostrarCuenta(int $idUsuario){
        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();
        return $cuenta;
    }



}
