<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modelos')->insert(['id' => '1', 'nome' => 'TRITON L200']);
        DB::table('modelos')->insert(['id' => '2', 'nome' => 'AMAROK']);
        DB::table('modelos')->insert(['id' => '3', 'nome' => 'JEEP RENEGADE']);

    }
}
