<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function verProfile(Request $request, string $id)
    {

        $perfis = Perfil::where('status', 's')->get();


        try {
            $user = User::where('cpf', $id)->first();
            return view('profile.edit', compact('user', 'perfis'));
        } catch (Exception $e) {
            Log::error('Erro ao consultar usuario', [$e]);
            return back()->with('warning', 'Houve um erro ao consultar o usuario');
        }
    }
    public function fotoPerfil()
    {
        return view('profile.foto');
    }

    public function upFoto(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $filename = $request->image->getClientOriginalName();
                $request->image->storeAs('images', $filename, 'local');
                //$request->file('image')->move('', $filename);
                User::where('cpf', $id)->update(['image' => $filename]);
                // return redirect()->back();
            } else {
                return back()->with('warning', 'Erro ao Atualizar dados');
            }

            DB::commit();
            Log::info('dados atualizado com sucesso', [Auth::user(), $id]);
            return redirect()->route('foto.perfil', $id)->with('success', 'Atualizado com Sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('erro ao atualizar dados do usuário', [$e]);
            return back()->with('warning', 'erro ao atualizar dados do usuário');
        }

    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $credentials = $request->validate([
                'password' => 'required|min:3|max:255'
            ], [
                'password.required' => 'Digite a senha atual para confirmar as alterações!',
            ]);

            $validate_user = User::query()->select('password')
                ->where('cpf', $id)->first();
            ;

            if ($validate_user && password_verify($request->get('password'), $validate_user->password)) {
                // here you know data is valid
                User::where('cpf', $id)->update([
                    'nome' => $request->get('nome'),
                    'sobrenome' => $request->get('sobrenome'),
                    'email' => $request->get('email'),
                    'telefone' => $request->get('telefone'),
                ]);
                if ($request->get('password_new') != null) {
                    User::where('cpf', $id)->update([
                        'nome' => $request->get('nome'),
                        'sobrenome' => $request->get('sobrenome'),
                        'email' => $request->get('email'),
                        'telefone' => $request->get('telefone'),
                        'password' => Hash::make($request->password_new),
                    ]);
                }
                if ($request->hasFile('image')) {
                    $filename = $request->image->getClientOriginalName();
                    $request->image->storeAs('images', $filename, 'public');
                    //$request->file('image')->move('', $filename);
                    User::where('cpf', $id)->update(['image' => $filename]);
                    // return redirect()->back();
                }
            } else {
                return back()->with('warning', 'Senha Incorreta');
            }


            DB::commit();
            Log::info('usuário atualizado com sucesso', [Auth::user(), $id]);
            return redirect()->route('profile.ver', $id)->with('success', 'Atualizado com Sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('erro ao atualizar dados do usuário', [$e]);
            return back()->with('warning', 'erro ao atualizar dados do usuário');
        }
    }
    public function destroy(Request $request): RedirectResponse
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('sistema.login');
    }
}
