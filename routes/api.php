<?php

use App\Http\Controllers\AutenticarController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\PublicacionesController;
use App\Models\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('registro',[AutenticarController::class,'registro']);
Route::post('login',[AutenticarController::class,'login']);

Route::post('users',[AutenticarController::class,'showUsers']);

Route::group(['middleware' => ['auth:sanctum']], function ()
{
    Route::post('logout',[AutenticarController::class,'logout']);
    Route::apiResource('posts',PublicacionesController::class);
    Route::apiResource('coments',ComentariosController::class);
});