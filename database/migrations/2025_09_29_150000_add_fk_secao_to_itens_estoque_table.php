<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('itens_estoque', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_secao')->nullable()->after('unidade');
            $table->foreign('fk_secao')->references('id')->on('secaos')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('itens_estoque', function (Blueprint $table) {
            $table->dropForeign(['fk_secao']);
            $table->dropColumn('fk_secao');
        });
    }
};
