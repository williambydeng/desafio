<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'usuario_publicador_id'];

    public $timestamps = false;

    public function indices()
    {
        return $this->hasMany(Indice::class);
    }

    public function usuario_publicador()
    {
        return $this->belongsTo(User::class, 'usuario_publicador_id');
    }
}