<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidades')->insert(['id' => '1', 'nome' => '1º BEPCIF']);
        DB::table('unidades')->insert(['id' => '2', 'nome' => '2º BEPCIF']);
        DB::table('unidades')->insert(['id' => '3', 'nome' => '3º BEPCIF']);
        DB::table('unidades')->insert(['id' => '4', 'nome' => '4º BEPCIF']);
        DB::table('unidades')->insert(['id' => '5', 'nome' => '5º BEPCIF']);
        DB::table('unidades')->insert(['id' => '6', 'nome' => '6º BEPCIF']);
        DB::table('unidades')->insert(['id' => '7', 'nome' => '7º BEPCIF']);
        DB::table('unidades')->insert(['id' => '8', 'nome' => '8º BEPCIF']);
        DB::table('unidades')->insert(['id' => '9', 'nome' => '9º BEPCIF']);
        DB::table('unidades')->insert(['id' => '10', 'nome' => 'COMANDO GERAL']);
        DB::table('unidades')->insert(['id' => '11', 'nome' => 'DAT']);
        DB::table('unidades')->insert(['id' => '12', 'nome' => 'DIRETORIA DE SAUDE']);
        DB::table('unidades')->insert(['id' => '13', 'nome' => 'DIRETORIA DE ENSINO']);

    }
}
