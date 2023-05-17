<?php

namespace App\Http\Controllers;

use App\Models\Publicaciones;
use App\Http\Requests\StorePublicacionesRequest;
use App\Http\Requests\UpdatePublicacionesRequest;
use App\Models\Comentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicacionesController extends Controller
{

    public function index()
    {
        $publicaciones = Publicaciones::paginate(10);
        $comentarios = $publicaciones->map(function ($item) {
            $item = Comentarios::with('publicacion')->where('id_publicacion', $item->id)->get();
            return $item;
        });
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
        $posts = new Publicaciones($datos);
        $posts->save();

        return response()->json([
            'status' => true,
            'message' => 'Publicacion guardada exitosamente'
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
        Publicaciones::where("id",$request->id)->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comentario editado exitosamente'
        ], 200);
    }

    public function destroy($id)
    {
        Comentarios::where('id_publicacion',$id)->delete();
        Publicaciones::where('id',$id)->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Publicacion eliminada'
        ], 200);
    }
}
