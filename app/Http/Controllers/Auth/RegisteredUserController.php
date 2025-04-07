<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Servico;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('sistema.registrar');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = $request->all();
            $user['password'] = Hash::make($request->password);
            $user['tipo'] = 'e';
            $user['status'] = 's';
            $user['fk_perfil'] = 1;
            $user['image'] = 'user.png';
            $user['cpf'] = str_replace('.', '', $user['cpf']);
            $user['cpf'] = str_replace('-', '', $user['cpf']);



            $user = User::create($user);
            event(new Registered($user));

            //Auth::login($user);

            DB::commit();
            Log::info('Usuário Externo criado', [$user]);
            return redirect()->route('login') ->with('message', 'Usuário Criado com Sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error ao criar usuário externo', [$e]);
            return back()->with('warning', 'Houve um erro ao criar usuário externo');
        }
    }
}
