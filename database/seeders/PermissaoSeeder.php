<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissoes')->insert(['id_permissao' => '1', 'modulo' => '1', 'nome' => 'Dashboard']);
        //---------------------------------------------------------------------------------
        DB::table('permissoes')->insert(['id_permissao' => '2', 'modulo' => '2', 'nome' => 'Parametros do Sistema']);
        //---------------------------------------------------------------------------------
        DB::table('permissoes')->insert(['id_permissao' => '3', 'modulo' => '3', 'nome' => 'Perfis de Acesso']);
        DB::table('permissoes')->insert(['id_permissao' => '4', 'modulo' => '3', 'nome' => 'Usuário']);
        //---------------------------------------------------------------------------------
        DB::table('permissoes')->insert(['id_permissao' => '5', 'modulo' => '4', 'nome' => 'Consultar']);
        //---------------------------------------------------------------------------------


    }
}
