<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;

    protected $table = 'comentarios';
    protected $fillable = [
        'autor',
        'contenido',
        'fecha_creacion'
    ];

    public function publicacion()
    {
        return $this->belongsTo(Comentarios::class, 'id_publicacion');
    }
}
