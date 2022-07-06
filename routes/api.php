<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CuentaController;
use \App\Http\Controllers\FollowerController;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\MultimediaController;


Route::post('register', [UsuarioController::class, 'register']);    // registro usuario
Route::post('login', [UsuarioController::class, 'authenticate']); //login

Route::group(['middleware' => ['jwt.verify']], function() {

    //Route::post('register/cuenta',[CuentaController::class, 'create']);   //Registrar cuenta

    Route::post('logout',[UsuarioController::class, 'logout']); //Cerrar sesión

    //HomeController
    Route::get('{username}/buscarUsuario', [HomeController::class, 'buscarUsuario']);
    Route::get('{idUsuario}/mostrarCuenta', [HomeController::class, 'mostrarCuenta']);

    //Cuenta
    Route::get('getCuenta',[CuentaController::class, 'getCuenta']);
    Route::put('editInfo',[CuentaController::class, 'editInfo']);

    //Seguidores
    Route::get('getSeguidores', [FollowerController::class, 'getSeguidores']);
    Route::get('getSeguidos', [FollowerController::class, 'getSeguidos']);
    Route::post('{idSeguido}/seguirUsuario', [FollowerController::class, 'seguirUsuario']);
    Route::delete('{idSeguido}/unfollowUsuario', [FollowerController::class, 'unfollowUsuario']);

    //Post
    Route::post('createPost', [PostController::class, 'createPost']);
    Route::put('{idPost}/editPost', [PostController::class, 'editPost']);
    Route::delete('{idPost}/deletePost', [PostController::class, 'deletePost']);
    Route::get('misPosts',[PostController::class,'misPosts']);
    Route::get('getPostSeguidos', [PostController::class, 'getPostSeguidos']);

    //Multimedia
    Route::post('subirFotoPerfil', [MultimediaController::class, 'subirFotoPerfil']);
    Route::get('getFotoPerfil', [MultimediaController::class, 'getFotoPerfil']);
    Route::get('{idPost}/getImagenPost', [MultimediaController::class, 'getImagenPost']);

});
