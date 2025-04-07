<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos')->insert(['id' => '1', 'nome' => 'CAMINHONETE']);
        DB::table('tipos')->insert(['id' => '2', 'nome' => 'UTILITARIO']);
        DB::table('tipos')->insert(['id' => '3', 'nome' => 'QUADRICICLO']);
        DB::table('tipos')->insert(['id' => '4', 'nome' => 'MOTO']);
        DB::table('tipos')->insert(['id' => '5', 'nome' => 'CAMINHAO']);


    }
}
