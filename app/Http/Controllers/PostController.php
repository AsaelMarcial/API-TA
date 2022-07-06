<?php

namespace App\Http\Controllers;


use App\Models\Multimedia;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function getPostSeguidos (Request $request){
        $logeado = $request->user()->id;
        $posts = Post::whereIn('idUsuario', DB::table('followers')->selectRaw('idSeguido as idUsuario')->where('idSeguidor', $logeado))
            ->orderBy('updated_at', 'desc')->get();
    }

    public function misPosts(Request $request){
        $posts = Post::where('idUsuario', $request->user()->id)->get();
        return response()->json($posts);
    }


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
        }

        $post->idMultimedia = $multimedia->id;
        $post->save();

        return response()->json([
            'message' => 'Post creado con éxito'
        ]);
    }

    public function editPost(Request $request, int $idpost){
        $rules = [
            'descripcion'=>'required|string',
            'ruta'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
        $this->validate($request, $rules);

        $post=Post::find($idpost);
        //$post->idUsuario = $request->user()->id;
        $post->descripcion = $request->input('descripcion');
        if ($request->hasFile("ruta")) {
            $multimedia = Multimedia::find($post->idMultimedia);
            if(Storage::exists($multimedia->ruta)){
                Storage::delete($multimedia->ruta);
                $multimedia->ruta->delete();
            }
            $multimedia->ruta = $request->file('ruta')->store('public/imagen');
            $multimedia->save();

        }
        $post->idMultimedia = $multimedia->id;
        $post->save();

        return response()->json([
            'message' => 'Post editado con éxito'
        ]);
    }

    public function deletePost(int $idpost){
        $post=Post::find($idpost);
        $multimedia = Multimedia::find($post->idMultimedia);
        if(Storage::exists($multimedia->ruta)){
            $post->delete();
            Storage::delete($multimedia->ruta);
            $multimedia->delete();
        }



        return response()->json([
            'message' => 'Post eliminado con éxito'
        ]);

    }
}
