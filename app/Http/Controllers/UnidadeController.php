<?php

namespace App\Http\Controllers;




use App\Models\Unidade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UnidadeController extends Controller
{

    public function listarUnidade(Request $request)
    {


        try {


            $unidades = Unidade::query()->paginate(10);





            return view('unidades/listarUnidades', compact('unidades'));
        } catch (Exception $e) {
            Log::error('Error ao consultar unidades', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar unidades');
        }

    }

    public function unidadeForm(Request $request)
    {

        //$this->authorize('autorizacao', 3);

        try {


            return view('unidades/formUnidade');



        } catch (Exception $e) {
            Log::error('Error ao consultar unidade', [$e]);
            return back()->with('warning', 'Houve um erro ao abrir Formulário');
        }
    }

    public function cadastrarUnidade(Request $request)
    {

      //  dd($request);
        // Obtém o valor da chave 'troca_de_oleo'

        $nome = $request->input('unidade');


        try {

            DB::beginTransaction();

            $unidade = Unidade::create(
                [
                    'nome' => $nome,
                ]
            );


            DB::commit();
            Log::info('Unidade registrada com sucesso', [$unidade, Auth::user()->cpf]);

            return redirect()->route('unidades.listar', $unidade->id)->with('success', 'Unidade registrado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error ao cadastrar nova Unidade', [$e]);
            return back()->with('warning', 'Houve um erro ao registrar Unidade');
        }
    }

    public function verUnidade(Request $request, $id)
    {


        try {

            $unidade_id = Unidade::where('id', $id)->first();

            $unidades = Unidade::all();


            return view('unidades/VerUnidade', compact('unidade_id', 'unidades'));


        } catch (Exception $e) {
            Log::error('Error ao consultar unidade', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Unidade');
        }
    }

    public function editarUnidade(Request $request, $id)
    {


        try {

            $unidade_id = Unidade::where('id', $id)->first();

            $unidades = Unidade::all();


            return view('unidades/editarUnidade', compact('unidade_id', 'unidades'));


        } catch (Exception $e) {
            Log::error('Error ao consultar unidade', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar a Unidade');
        }
    }

    public function atualizarUnidade(Request $request, $id)
    {

        $unidade = $request->input('unidade');



        try {
            DB::beginTransaction();

            // Encontra a unidade correspondente ao ID
            $unidade_id = Unidade::findOrFail($id);



            // Atualize o registro
            $unidade_id->update([
                'nome' => $unidade,

            ]);

            DB::commit();

            Log::info('Unidade atualizado com sucesso', [$unidade_id, Auth::user()->cpf]);

            return redirect()->route('unidade.ver', $unidade_id)->with('success', 'Unidade atualizado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar o unidade', [$e]);

            return back()->with('warning', 'Erro ao atualizar a Unidade');
        }

    }


}
