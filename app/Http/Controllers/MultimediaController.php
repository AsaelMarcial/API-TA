<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Multimedia;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\u;

class MultimediaController extends Controller
{
    public function subirFotoPerfil(Request $request){

        $rules = [
            'ruta'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
        $this->validate($request, $rules);

        $idUsuario = $request->user()->id;
        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();

        if ($request->hasFile("ruta")) {
            if($cuenta->idMultimedia == null){
                $nuevamultimedia = new Multimedia();
                $nuevamultimedia->ruta = $request->file('ruta')->store('public/imagen');
                $nuevamultimedia->save();
                $cuenta->idMultimedia = $nuevamultimedia->id;
                $cuenta->save();
                return response()->json([
                    'message' => 'NUEVA Foto de perfil guardada con éxito'
                ]);
            }
            else{
                $multimedia = Multimedia::find($cuenta->idMultimedia);
                Storage::delete($multimedia->ruta);
                $multimedia->ruta = $request->file('ruta')->store('public/imagen');
                $multimedia->save();
                return response()->json([
                    'message' => 'Foto de perfil cambiada con éxito'
                ]);
            }
        }
    }

    public function getFotoPerfil(Request $request){
        $idUsuario = $request->user()->id;
        $cuenta = Cuenta::where('idUsuario', $idUsuario)->first();
        $imagen = Multimedia::find($cuenta->idMultimedia)->first();
        return $imagen->ruta;
    }

    public function getImagenPost(int $idMultimedia){
        $imagen = Multimedia::find($idMultimedia);
        return $imagen->ruta;
    }

}
