<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    public function permissoes(){
        return $this->belongsToMany(PerfilPermissao::class, 'perfis', 'id_perfil', 'id_perfil', 'id_perfil', 'fk_perfil');
    }

    protected $fillable = [
        'id_perfil',
        'nome',
        'status'
    ];
}
