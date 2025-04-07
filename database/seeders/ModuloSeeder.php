<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modulos')->insert(['id_modulo' => '1', 'nome' => 'Dashboard']);
        DB::table('modulos')->insert(['id_modulo' => '2', 'nome' => 'Administração']);
        DB::table('modulos')->insert(['id_modulo' => '3', 'nome' => 'Segurança']);
        DB::table('modulos')->insert(['id_modulo' => '4', 'nome' => 'Registros']);
        DB::table('modulos')->insert(['id_modulo' => '5', 'nome' => 'Relatórios']);

    }
}
