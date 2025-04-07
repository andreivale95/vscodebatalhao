<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('perfis')->insert(['nome' => 'Administrador', 'status' => 's']);




        // Permições do Adiministrador
        DB::table('perfil_permissao')->insert(['fk_perfil' => '1', 'fk_permissao' => '1']);
        DB::table('perfil_permissao')->insert(['fk_perfil' => '1', 'fk_permissao' => '2']);
        DB::table('perfil_permissao')->insert(['fk_perfil' => '1', 'fk_permissao' => '3']);
        DB::table('perfil_permissao')->insert(['fk_perfil' => '1', 'fk_permissao' => '4']);
        DB::table('perfil_permissao')->insert(['fk_perfil' => '1', 'fk_permissao' => '5']);

    }
}
