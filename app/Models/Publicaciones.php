<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    use HasFactory;
    protected $table = 'publicaciones';
    protected $fillable = [
        'titulo',
        'contenido',
        'fecha_creacion'
    ];

    // public function publicacion()
    // {
    //     return $this->belongsTo(Comentarios::class, 'id_publicacion');
    // }
}
