<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilPermissao extends Model
{
    use HasFactory;

    protected $table = 'perfil_permissao';

    public function permissao(){
        return $this->hasOne(Permissao::class, 'id_permissao', 'fk_permissao');
    }
    public function perfil(){
        return $this->hasOne(Perfil::class, 'id_perfil', 'fk_perfil');
    }

    protected $fillable = [
        'fk_perfil',
        'fk_permissao',


    ];
}
