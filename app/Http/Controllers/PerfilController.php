<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\PerfilPermissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function listarPerfis(Request $request)
    {

        $this->authorize('autorizacao', 3);

        try {
            $perfis = Perfil::all();
            $permissoes = Permissao::all();
            $perfilpermissoes = PerfilPermissao::all();
        } catch (Exception $e) {
            Log::error('Error ao consultar os perfis', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar os perfis');
        }


        return view('perfil/listarPerfis', compact('perfis', 'permissoes', 'perfilpermissoes'));
    }

    public function verPerfil(Request $request, $id)
    {

        $this->authorize('autorizacao', 3);

        try {
            $modulos = Modulo::all();
            $permissoes = Permissao::all();
            $perfil = Perfil::query()
                ->where('id_perfil', $id)
                ->first();

            return view('perfil/verPerfil', compact('perfil', 'modulos', 'permissoes'));
        } catch (Exception $e) {
            Log::error('Error ao consultar os perfis', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar o perfil');
        }
    }

    public function formPerfil(Request $request)
    {

        $this->authorize('autorizacao', 3);

        try {
            $modulos = Modulo::all();
            $permissoes = Permissao::all();

            return view('perfil/formPerfil', compact('modulos', 'permissoes'));
        } catch (Exception $e) {
            Log::error('Error ao consultar os perfis', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar o perfil');
        }
    }


    public function criarPerfil(Request $request)
    {

        $this->authorize('autorizacao', 3);

        try {
            DB::beginTransaction();

            $p = Perfil::create([
                'nome' => $request->get('nome'),
                'status' => 's',
            ]);

            $per = $request->all();
            unset($per['_token']);
            unset($per['nome']);


            foreach ($per as $key => $value) {
                PerfilPermissao::create([
                    'fk_perfil' => $p->id,
                    'fk_permissao' => $key
                ]);
            }

            DB::commit();
            Log::info('Perfil criado', [Auth::user(), $p]);
            return redirect()->route('pf.listar')->with('success', 'Perfil de usuário criado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Erro ao Criar SAT', [$e]);
            return back()->with('warning', 'Houve um erro na criação da perfil');
        }
    }

    public function editarPerfil(Request $request, string $id)
    {

        $this->authorize('autorizacao', 3);

        try {
            DB::beginTransaction();

            $modulos = Modulo::all();
            $permissoes = Permissao::all();
            $perfil = Perfil::query()
                ->where('id_perfil', $id)
                ->first();

            DB::commit();
            return view('perfil/editarPerfil', compact('perfil', 'modulos', 'permissoes'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error ao consultar os perfil', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar o perfil');
        }
    }


    public function atualizarPerfil(Request $request, string $id)
    {

        $this->authorize('autorizacao', 3);

        try {
            DB::beginTransaction();

            Perfil::query()
                ->where('id_perfil', $id)
                ->update([
                    'nome' => $request->get('nome'),
                    'status' => $request->get('status')
                ]);

            $per = $request->all();
            unset($per['_token']);
            unset($per['nome']);
            unset($per['status']);

            PerfilPermissao::query()
                ->where('fk_perfil', $id)
                ->delete();

            foreach ($per as $key => $value) {
                PerfilPermissao::create([
                    'fk_perfil' => $id,
                    'fk_permissao' => $key
                ]);
            }

            DB::commit();
            Log::info('Perfil atualizado', [Auth::user(), $id]);
            return redirect()->route('pf.listar')->with('success', 'Perfil de usuário atualizado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Erro ao atualiar perfil', [$e]);
            return back()->with('warning', 'Houve um erro na atualização do perfil');
        }
    }

    public function deletarPerfil(Request $request, $id)
    {

        $this->authorize('autorizacao', 3);

        try {
            DB::beginTransaction();

            PerfilPermissao::query()
                ->where('fk_perfil', $id)
                ->delete();

            Perfil::query()
                ->where('id_perfil', $id)
                ->delete();


            DB::commit();
            Log::info('Perfil deletado', [Auth::user(), $id]);
            return redirect()->route('pf.listar')->with('success', 'Perfil de usuário deletado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Erro ao atualiar perfil', [$e]);
            return back()->with('warning', 'Houve um erro na atualização do perfil');
        }
    }
}
