<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa');
            $table->string('ano');
            $table->string('tipo');
            $table->string('troca_de_oleo');
            $table->string('fluido_de_arrefecimento');
            $table->string('fluido_de_freio');
            $table->string('caixa_de_transferencia');
            $table->string('oleo_eixo');
            $table->string('oleo_transmissao');
            $table->string('oleo_diferencial');
            $table->string('chassi');
            $table->decimal('odometro');
            $table->unsignedBigInteger('modelo');
            $table->unsignedBigInteger('unidade');
            $table->timestamps();

            //$table->foreign('marca_arma')->references('id')->on('marcas');
            //$table->foreign('especie_arma')->references('id')->on('especies_armas');
            //$table->foreign('grupo_calibre')->references('id')->on('grupo_calibre_arma');
            //$table->foreign('tipo_funcionamento')->references('id')->on('tipo_funcionamento');
            //$table->foreign('pais')->references('id')->on('pais');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
