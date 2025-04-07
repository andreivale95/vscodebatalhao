<?php

use App\Models\Usuario;
use App\Models\Sat;
use App\Models\Perfil;
//use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

uses(TestCase::class);

beforeEach(function() {
    $this->actingAs(Sat::factory()->create());
    $this->actingAs(Perfil::factory()->create());
    $this->actingAs(Usuario::factory()->create());
});

describe("Testes de criação de Usuarios", function(){
    test('cria um usuário', function () {
        Usuario::factory()->create();
     });
});

describe("Testes de consultas de Usuarios", function(){
    test('pega todos os usuário', function () {
        //$users = Usuario::all();
        $this->assertCount(0, Usuario::all());
     });
});
