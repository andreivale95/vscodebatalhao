<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Rio Branco', 'bairro' => 'Aviário', 'endereco' => 'Travessa Santa Inês', 'numero' => '97', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Sena Madureira', 'bairro' => 'Cidade Nova', 'endereco' => 'Rua Piauí', 'numero' => '101', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Cruzeiro do Sul', 'bairro' => '25 de Agosto', 'endereco' => 'Rua Rio Grande do Sul', 'numero' => '1106', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Tarauacá', 'bairro' => 'Ipepaconha', 'endereco' => 'Rua João Pessoa', 'numero' => '1730', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Epitacionlândia', 'bairro' => 'Pôr do Sol', 'endereco' => 'Ramal do Girão', 'numero' => '106', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Feijó', 'bairro' => 'Centro', 'endereco' => 'Travessa Floriano Peixoto', 'numero' => '261', 'complemento' => '']);
        DB::table('enderecos')->insert(['cep' => '-', 'estado' => 'Acre', 'cidade' => 'Xapuri', 'bairro' => 'Cageacre', 'endereco' => 'Estrada da Borracha, Km 01', 'numero' => '0', 'complemento' => '']);

        \App\Models\Endereco::factory(30)->create();
    }
}
