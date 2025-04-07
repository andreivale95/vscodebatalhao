<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kit extends Model
{
    use HasFactory;

    protected $table = 'kits';

    protected $fillable = [
        'nome',
        'descricao',
        'fk_unidade',


    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'kit_produto', 'fk_kit', 'fk_produto')
            ->withPivot('quantidade');
    }

    // Kit.php
    public function itens()
    {
        return $this->hasMany(KitProduto::class, 'fk_kit'); // fk_kit é o nome da foreign key na tabela kit_produto
    }

    public function unidade()
    {
        return $this->hasOne(Unidade::class, 'id', 'fk_unidade');
    }





}
