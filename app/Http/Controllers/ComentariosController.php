<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use App\Http\Requests\StoreComentariosRequest;
use App\Http\Requests\UpdateComentariosRequest;
use App\Models\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComentariosController extends Controller
{
    
    public function index()
    {
        $comentarios = Comentarios::all();
        // $comentarios = $publicaciones->map(function ($item) {
        //     $item = Publicaciones::with('publicacion')->where('id_publicacion', $item->id)->get();
        //     return $item;
        // });
        return response()->json($comentarios, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'titulo' => 'required|string|min:5|max:100',
            'contenido' => 'required|string|min:10|max:255'
        ];
        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 403);
        }
        $datos = $request->input();
        $datos['fecha_creacion'] = date('Y-m-d H:m:s');
        $posts = new Comentarios($datos);
        $posts->save();

        return response()->json([
            'status' => true,
            'message' => 'Comentario guardada exitosamente'
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'titulo' => 'required|string|min:5|max:100',
            'contenido' => 'required|string|min:20|max:255'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 403);
        }
        Comentarios::where("id",$request->id)->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comentario editado exitosamente'
        ], 200);
    }

    public function destroy($id)
    {
        Comentarios::where('id_publicacion',$id)->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Comentario eliminada'
        ], 200);
    }
}
