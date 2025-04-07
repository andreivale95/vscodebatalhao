<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function autorizacao(User $user, int $permissao){
        $permissoes = $user->perfil()->get()->first()->permissoes()->get();
        foreach($permissoes as $per){
            if($per->fk_permissao == $permissao)
                return true;
        }
        return false;
    }
}
