<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitProduto extends Model
{
    use HasFactory;

    protected $table = 'kit_produto';

    protected $fillable = [
        'fk_kit',
        'fk_produto',
        'quantidade',


    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'kit_produto')
            ->withPivot('quantidade');
    }

    public function kit()
{
    return $this->belongsTo(Kit::class, 'fk_kit');
}



}
