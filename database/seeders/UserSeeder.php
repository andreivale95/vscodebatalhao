<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Faker\Provider\pt_BR\PhoneNumber;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\Internet;
use Nette\Utils\Random;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'nome' => 'Adriano',
            'sobrenome' => 'Albuquerque',
            'email' => 'adrianoalbuquerquejd@gmail.com',
            'cpf' => '04573109285',
            'password' => Hash::make('123'),
            'telefone' => PhoneNumber::phone(),

            'fk_perfil' => 1,

            'status' => 's',
            'image' => 'perfil.png',
            'email_verified_at' => '2024-02-05 09:44:21'
        ]);

        DB::table('users')->insert([
            'nome' => 'Wilker',
            'sobrenome' => 'Rodrigues',
            'email' => 'rodrigues.wilker@gmail.com',
            'cpf' => '01462263216',
            'password' => Hash::make('123'),
            'telefone' => PhoneNumber::phone(),

            'fk_perfil' => 1,

            'status' => 's',
            'image' => 'perfil.png',
            'email_verified_at' => '2024-02-05 09:44:21'
        ]);





    }
}
