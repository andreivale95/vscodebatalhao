<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secao;
use App\Models\Unidade;
use App\Models\Itens_estoque;

class SecaoController extends Controller
{
    public function ver($unidadeId, $secaoId)
    {
        $secao = Secao::with(['unidade'])->findOrFail($secaoId);
        $itens = Itens_estoque::where('fk_secao', $secaoId)->get();
        $outrasSecoes = Secao::where('fk_unidade', $unidadeId)->where('id', '!=', $secaoId)->get();
        return view('secoes.ver', compact('secao', 'itens', 'outrasSecoes', 'unidadeId'));
    }

    public function transferirItens(Request $request, $unidadeId, $secaoId)
    {
        $request->validate([
            'item_id' => 'required|array',
            'nova_secao' => 'required|integer',
        ]);
        foreach ($request->item_id as $itemId) {
            $item = Itens_estoque::find($itemId);
            if ($item) {
                $item->fk_secao = $request->nova_secao;
                $item->save();
            }
        }
        return redirect()->route('secoes.ver', ['unidade' => $unidadeId, 'secao' => $secaoId])->with('success', 'Itens transferidos com sucesso!');
    }
    public function index($unidadeId)
    {
        $unidade = Unidade::with('secoes')->findOrFail($unidadeId);
        return view('secoes.index', compact('unidade'));
    }

    public function create($unidadeId)
    {
        $unidade = Unidade::findOrFail($unidadeId);
        return view('secoes.create', compact('unidade'));
    }

    public function store(Request $request, $unidadeId)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);
        Secao::create([
            'nome' => $request->nome,
            'fk_unidade' => $unidadeId,
        ]);
        return redirect()->route('secoes.index', $unidadeId)->with('success', 'Seção cadastrada com sucesso!');
    }

    public function edit($unidadeId, $id)
    {
        $unidade = Unidade::findOrFail($unidadeId);
        $secao = Secao::findOrFail($id);
        return view('secoes.edit', compact('unidade', 'secao'));
    }

    public function update(Request $request, $unidadeId, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);
        $secao = Secao::findOrFail($id);
        $secao->update(['nome' => $request->nome]);
        return redirect()->route('secoes.index', $unidadeId)->with('success', 'Seção atualizada com sucesso!');
    }

    public function destroy($unidadeId, $id)
    {
        $secao = Secao::findOrFail($id);
        $secao->delete();
        return redirect()->route('secoes.index', $unidadeId)->with('success', 'Seção excluída com sucesso!');
    }
    public function vincularItensForm($secaoId)
    {
        $secao = Secao::findOrFail($secaoId);
        $itens = Itens_estoque::where('unidade', $secao->fk_unidade)->get();
        return view('secoes.vincular_itens', compact('secao', 'itens'));
    }

    public function vincularItens(Request $request, $secaoId)
    {
        $secao = Secao::findOrFail($secaoId);
        $itens = $request->input('itens', []);
        $quantidades = $request->input('quantidades', []);
        foreach ($itens as $idx => $itemId) {
            if ($itemId && isset($quantidades[$idx]) && $quantidades[$idx] > 0) {
                $item = Itens_estoque::find($itemId);
                if ($item) {
                    $item->fk_secao = $secaoId;
                    $item->quantidade += $quantidades[$idx]; // Soma à quantidade existente
                    $item->save();
                }
            }
        }
        return redirect()->route('secoes.vincular_itens_form', ['unidade' => $secao->fk_unidade, 'secao' => $secao->id])->with('success', 'Itens vinculados à seção com sucesso!');
    }
}
