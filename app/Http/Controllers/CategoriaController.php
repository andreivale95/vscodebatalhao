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


        $nome = $request->input('nome');
        $tipo_tamanho = $request->input('tipo_tamanho');


        try {

            DB::beginTransaction();

            $categoria = Categoria::create(
                [
                    'nome' => $nome,
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

            $categoria_id = Categoria::where('id', $id)->first();

            $categorias = Categoria::all();


            return view('categorias/VerCategoria', compact('categoria_id', 'unidades'));


        } catch (Exception $e) {
            Log::error('Error ao consultar categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Categoria');
        }
    }

    public function editarUnidade(Request $request, $id)
    {


        try {


            $categoria_id = Categoria::where('id', $id)->first();

            $categorias = Categoria::all();


            return view('categorias/editarCategoria', compact('categoria_id', 'categorias'));


        } catch (Exception $e) {
            Log::error('Error ao consultar categoria', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Categoria');
        }
    }

    public function atualizarCategoria(Request $request, $id)
    {

        $categoria = $request->input('nome');
        $tipo_tamanho = $request->input('tipo_tamanho');



        try {
            DB::beginTransaction();


            $categoria_id = Categoria::findOrFail($id);




            // Atualize o registro
            $categoria_id->update([
                'nome' =>   $categoria,
                'tipo_tamanho' => $tipo_tamanho ?? 'Nao definido',
            ])->save();




            DB::commit();

            Log::info('Categoria atualizado com sucesso', [ $categoria_id, Auth::user()->cpf]);

            return redirect()->route('categoria.ver',  $categoria_id)->with('success', 'Categoria atualizado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar a Categoria', [$e]);

            return back()->with('warning', 'Erro ao atualizar a Categoria');
        }

    }


}
