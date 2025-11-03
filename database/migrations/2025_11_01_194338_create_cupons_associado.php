<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cupom_associado', function (Blueprint $table) {
            $table->integer('id_cupom_associado')->primary();
            $table->char('num_cupom', 12);
            $table->string('cpf_associado', 20);
            $table->date('dta_cupom_associado');
            $table->date('dta_uso_cupom_associado')->nullable();

            $table->foreign('num_cupom')
                ->references('num_cupom')->on('cupons');

            $table->foreign('cpf_associado')
                ->references('cpf_associado')->on('associados');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupom_associado');
    }
};
