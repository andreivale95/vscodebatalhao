<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    use HasFactory;

    protected $table = 'tipoprodutos';

    protected $fillable = [
        'nome',
        'fk_categoria',
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'fk_categoria');
    }







}
