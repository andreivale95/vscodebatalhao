<?php

namespace App\Http\Controllers;




use App\Models\Categoria;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CategoriaController extends Controller
{

    public function listarCategoria(Request $request)
    {


        try {


            $categorias = Categoria::query()->paginate(10);



            return view('categorias/listarCategorias', compact('categorias'));
        } catch (Exception $e) {
            Log::error('Error ao consultar categorias', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar categorias');
        }

    }

    public function CategoriaForm(Request $request)
    {


        try {


            return view('categorias/formCategoria');



        } catch (Exception $e) {
            Log::error('Error ao consultar categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao abrir Formulário');
        }
    }

    public function cadastrarCategoria(Request $request)
    {


        $categoria = $request->input('nome');
        $tipo_tamanho = $request->input('tipo_tamanho');


        try {

            DB::beginTransaction();

            $categoria = Categoria::create(
                [
                    'nome' => $categoria,
                    'tipo_tamanho' => $tipo_tamanho ?? 'Nao definido',
                ]
            );


            DB::commit();
            Log::info('Categoria registrada com sucesso', [$categoria, Auth::user()->cpf]);

            return redirect()->route('categorias.listar', $categoria->id)->with('success', 'Categoria registrado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error ao cadastrar nova Categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao registrar Categoria');
        }
    }

    public function verCategoria(Request $request, $id)
    {


        try {

            $categoria = Categoria::where('id', $id)->first();

            $categorias = Categoria::all();


            return view('categorias/VerCategoria', compact('categoria', 'categorias'));


        } catch (Exception $e) {
            Log::error('Error ao consultar categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Categoria');
        }
    }

    public function editarCategoria(Request $request, $id)
    {


        try {


            $categoria = Categoria::where('id', $id)->first();

            $categorias = Categoria::all();


            return view('categorias/editarCategoria', compact('categoria', 'categorias'));


        } catch (Exception $e) {
            Log::error('Error ao consultar categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Categoria');
        }
    }

    public function atualizarCategoria(Request $request, $id)
    {

        $nome = $request->input('nome');
        $tipo_tamanho = $request->input('tipo_tamanho');

        try {
            DB::beginTransaction();
            $categoria = Categoria::findOrFail($id);
            $categoria->update([
                'nome' => $nome,
                'tipo_tamanho' => $tipo_tamanho ?? 'Nao definido',
            ]);
            DB::commit();
            Log::info('Categoria atualizado com sucesso', [$categoria, Auth::user()->cpf]);
            return redirect()->route('categoria.ver', $categoria->id)->with('success', 'Categoria atualizado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar a Categoria', [$e]);
            return back()->with('warning', 'Erro ao atualizar a Categoria');
        }
    }

    public function excluirCategoria(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            DB::commit();
            Log::info('Categoria excluída com sucesso', [$categoria, Auth::user()->cpf]);
            return redirect()->route('categorias.listar')->with('success', 'Categoria excluída com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir a Categoria', [$e]);
            return back()->with('warning', 'Erro ao excluir a Categoria');
        }
    }


}
