<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Usuario;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/{username}/buscarUsuario",
     *     tags={"BUSQUEDA"},
     *     summary="Busca a un usuario por su username.",
     *     operationId="buscarUsuario",
     *     @OA\Parameter(
     *          name="username",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud exitosa"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la solicitud"
     *     ),
     *     security={
     *         {"apiAuth": {}}
     *     }
     * )
     *
     *
     * @param Request $request
     * @return void
     */
    public function buscarUsuario(string $username){
        $usuario=Usuario::where('username', $username)->first();
        return $usuario;
    }

/**
     * @OA\Get(
     *     path="/{idUsuario}/mostrarCuenta",
     *     tags={"BUSQUEDA"},
     *     summary="Muestra una cuenta.",
     *     operationId="mostrarCuenta",
     *     @OA\Parameter(
     *          name="idUsuario",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud exitosa"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de solicitud"
     *     ),
     *     security={
     *         {"apiAuth": {}}
     *     }
     * )
     *
     *
     * @param Request $request
     * @return void
     */

    public function mostrarCuenta(int $idUsuario){
        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();
        return $cuenta;
    }



}
