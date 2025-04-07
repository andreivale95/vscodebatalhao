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
        Schema::create('oleos', function (Blueprint $table) {
            $table->id();
            $table->char('cpf', 14);
            $table->string('oficina');
            $table->date('data');
            $table->decimal('odometro');
            $table->date('data_prox');
            $table->decimal('odometro_prox');
            $table->unsignedBigInteger('veiculo');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oleos');
    }
};
