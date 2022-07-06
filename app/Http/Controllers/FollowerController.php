<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Usuario;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
/**
     * @OA\Get(
     *     path="/getSeguidores",
     *     tags={"FOLLOWERS"},
     *     summary="Obtiene los usuarios a los que sigue la cuenta.",
     *     operationId="getSeguidores",
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
    public function getSeguidores(Request $request){
        $seguidores = Usuario::find($request->user()->id);
        return $seguidores->seguidores->count();

    }

    /**
     * @OA\Get(
     *     path="/getSeguidos",
     *     tags={"FOLLOWERS"},
     *     summary="Obtiene los usuarios que siguen la cuenta.",
     *     operationId="getSeguidos",
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
    public function getSeguidos(Request $request){
        $seguidos = Usuario::find($request->user()->id);
        return $seguidos->seguidos->count();
    }

    /**
     * @OA\Post(
     *     path="/{idSeguido}/seguirUsuario",
     *     tags={"FOLLOWERS"},
     *     summary="Seguir a un usuario.",
     *     operationId="seguirUsuario",
     *     @OA\Parameter(
     *          name="idSeguido",
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
    public function seguirUsuario(Request $request, $idSeguido){
        $usuario = Usuario::find($request->user()->id);
        $seguido = new Follower();
        $seguido->idSeguidor = $usuario->id;
        $seguido->idSeguido = $idSeguido;
        $seguido->save();

        return response()->json([
            'message' => 'Usuario seguido con éxito'
        ]);
    }

     /**
     * @OA\Delete(
     *     path="/{idSeguido}/unfollowUsuario",
     *     tags={"FOLLOWERS"},
     *     summary="Dejar de seguir a un usuario.",
     *     operationId="unfollowUsuario",
     *     @OA\Parameter(
     *          name="idSeguido",
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
    public function unfollowUsuario(Request $request, int $idSeguido){
        $idUsuario = Usuario::find($request->user()->id);
        $seguido = Follower::where('idSeguido', $idSeguido)->where('idSeguidor', $idUsuario)->delete();
        return response()->json([
            'message' => 'Dejaste de seguir al usuario con éxito'
        ]);
    }

}
