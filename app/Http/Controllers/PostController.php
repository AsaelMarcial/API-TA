<?php

namespace App\Http\Controllers;


use App\Models\Multimedia;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    /**
     * @OA\Get(
     *     path="/getPostSeguidos",
     *     tags={"POSTS"},
     *     summary="Obtiene las publicaciones de los usuarios seguidos.",
     *     operationId="getPostSeguidos",
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

    public function getPostSeguidos (Request $request){
        $logeado = $request->user()->id;
        $posts = Post::whereIn('idUsuario', DB::table('followers')->selectRaw('idSeguido as idUsuario')->where('idSeguidor', $logeado))
            ->orderBy('updated_at', 'desc')->get();
    }


     /**
     * @OA\Get(
     *     path="/misPosts",
     *     tags={"POSTS"},
     *     summary="Obtiene las publicaciones de los usuarios logeado.",
     *     operationId="misPosts",
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
    public function misPosts(Request $request){
        $posts = Post::where('idUsuario', $request->user()->id)->get();
        return response()->json($posts);
    }


    /**
     * @OA\Post(
     *     path="/createPost",
     *     tags={"POSTS"},
     *     summary="Crea un publicación.",
     *     operationId="createPost",
     *     @OA\Parameter(
     *          name="descripcion",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="ruta",
     *          in="query",
     *          required=false,
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
    public function createPost(Request $request){
        $rules = [
            'descripcion'=>'required|string',
            'ruta'=>'image|mimes:jpeg,png,jpg|max:2048'
        ];
        $this->validate($request, $rules);

        $post = new Post();
        $post->idUsuario = $request->user()->id;
        $post->descripcion = $request->input('descripcion');

        //Agregar multimedia
        if ($request->hasFile("ruta")) {
            $multimedia = new Multimedia();
            $multimedia->ruta = $request->file('ruta')->store('public/imagen');
            $multimedia->save();
        }else{
            $multimedia = new Multimedia();
            $multimedia->ruta = null;
            $multimedia->save();
        }

        $post->save();

        return response()->json([
            'message' => 'Post creado con éxito'
        ]);
    }


    /**
     * @OA\Put(
     *     path="/{idPost}/editPost",
     *     tags={"POSTS"},
     *     summary="Edita un publicación.",
     *     operationId="editPost",
     *     @OA\Parameter(
     *          name="idPost",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="descripcion",
     *          in="query",
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

    public function editPost(Request $request, int $idpost){
        $rules = [
            'descripcion'=>'required|string',
            'ruta'=>'image|mimes:jpeg,png,jpg|max:2048'
        ];
        $this->validate($request, $rules);

        $post=Post::find($idpost);
        //$post->idUsuario = $request->user()->id;
        $post->descripcion = $request->input('descripcion');
        /*if ($request->hasFile("ruta")) {
            $multimedia = Multimedia::find($post->idMultimedia);
            if(Storage::exists($multimedia->ruta)){
                Storage::delete($multimedia->ruta);
                $multimedia->ruta->delete();
            }
            $multimedia->ruta = $request->file('ruta')->store('public/imagen');
            $multimedia->save();

        }
        $post->idMultimedia = $multimedia->id;*/
        $post->save();

        return response()->json([
            'message' => 'Post editado con éxito'
        ]);
    }



     /**
     * @OA\Delete(
     *     path="/{idPost}/deletePost",
     *     tags={"POSTS"},
     *     summary="Elimina una publicación.",
     *     operationId="deletePost",
     *     @OA\Parameter(
     *          name="idPost",
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
    public function deletePost(int $idpost){
        $post=Post::find($idpost);
        $post->delete();
        /*$multimedia = Multimedia::find($post->idMultimedia);
        if(Storage::exists($multimedia->ruta)){
            
            Storage::delete($multimedia->ruta);
            $multimedia->delete();
        }*/

        return response()->json([
            'message' => 'Post eliminado con éxito'
        ]);

    }
}
