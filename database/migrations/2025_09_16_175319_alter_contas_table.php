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
        Schema::table('contas', function (Blueprint $table) {
            $table->unsignedBigInteger('situacao_conta_id')->after('vencimento')->default(2);
            $table->foreign('situacao_conta_id')->references('id')->on('situacoes_contas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->dropColumn('situacao_conta_id');
        });
    }
};
