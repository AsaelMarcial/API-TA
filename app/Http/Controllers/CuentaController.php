<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Multimedia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CuentaController extends Controller
{
    public function create(Request $request){
        $rules = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:cuentas',
            'telefono' => 'required|max:10',
            'genero' => 'required|string',
            'info' => 'string'
        ];
        $this->validate($request, $rules);

        $cuenta = new Cuenta();
        $cuenta->idUsuario = $request->user()->id;
        $cuenta->idMultimedia= null;
        $cuenta->nombre = $request->input('nombre');
        $cuenta->apellidos = $request->input('apellidos');
        $cuenta->email = $request->input('email');
        $cuenta->info = $request->input('info');

        $cuenta->save(); //INSERT

        return response()->json([
            'message' => 'Cuenta creada con éxito'
        ]);
    }

    public function editInfo(Request $request){
        $rules = [
            'info' => 'required|string'
        ];
        $this->validate($request, $rules);

        $idUsuario = $request->user()->id;

        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();

        $cuenta->info = $request->input('info');
        $cuenta->save(); //UPDATE

        return response()->json([
            'message' => 'Info editada con éxito'
        ]);
    }

    public function getCuenta (Request $request){
        $idUsuario = $request->user()->id;
        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();
        return $cuenta;
    }
}
