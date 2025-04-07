<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class SegurancaController extends Controller
{
    public function listaPerfis(Request $request){
        $perfis = Perfil::all();
        $permissoes = Permissao::all();
        return view('seguranca/perfis', compact('perfis', 'permissoes'));
    }
}
