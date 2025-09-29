<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use HasFactory;

    protected $table = 'secaos';
    protected $fillable = ['nome', 'fk_unidade'];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'fk_unidade');
    }
}
