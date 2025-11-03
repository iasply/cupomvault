<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->char('num_cupom', 12)->primary();
            $table->string('tit_cupom', 25);
            $table->string('cnpj_comercio', 20);
            $table->date('dta_emissao_cupom');
            $table->date('dta_inicio_cupom');
            $table->date('dta_termino_cupom');
            $table->decimal('per_desc_cupom', 5, 2);
            $table->foreign('cnpj_comercio')
                ->references('cnpj_comercio')->on('comercios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
