<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->comment('Tabela que lista as os modulos de acesso do sistema');

            $table->integer('id_modulo')->unsigned()->autoIncrement();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('permissoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->comment('Tabela que lista as permições de acesso do usuário');

            $table->integer('id_permissao')->unsigned()->autoIncrement();
            $table->string('nome');
            $table->integer('modulo')->unsigned()->comment('usado pra identificar de qual modulo pertence');
            $table->timestamps();

            $table->foreign('modulo')->references('id_modulo')->on('modulos');
        });

        Schema::create('perfis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->comment('Tabela usada pra ceder as permições de acesso e atrelada ao usuario');

            $table->integer('id_perfil')->unsigned()->autoIncrement();
            $table->string('nome');
            $table->enum('status', ['s','n']);      // Status de usuário s=ativo, n=inativo
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->comment('Tabela de usuários usada pra autenticação e ações da aplicação');

            $table->integer('fk_perfil')->unsigned()->nullable()->comment('fk usada pra refenciar a tabela de perfis');

            $table->string('nome');
            $table->string('sobrenome');
            $table->char('cpf', 14)->primary();
            $table->string('email');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telefone')->nullable();

            $table->enum('status', ['s','n'])->default('n')->comment('Status do usuário s=Ativo, n=Inativo');
            $table->string('image')->default('user.png');


            $table->rememberToken();
            $table->timestamps();

            $table->foreign('fk_perfil')->references('id_perfil')->on('perfis');

        });

        Schema::create('perfil_permissao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->comment('Tabela que linka o perfil de usuário as permições de perfil');

            $table->integer('fk_perfil')->unsigned()->comment('fk usada pra refenciar a tabela de perfis');
            $table->integer('fk_permissao')->unsigned()->comment('fk usada pra refenciar a tabela de permissoes');
            $table->timestamps();

            $table->foreign('fk_perfil')->references('id_perfil')->on('perfis');
            $table->foreign('fk_permissao')->references('id_permissao')->on('permissoes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('perfils');
        Schema::dropIfExists('permissoes');
        Schema::dropIfExists('perfils_permissoes');
    }
};
