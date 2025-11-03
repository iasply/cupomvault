<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('associados', function (Blueprint $table) {
            $table->string('cpf_associado', 20)->primary();
            $table->string('nom_associado', 40);
            $table->date('dtn_associado')->nullable();
            $table->string('end_associado', 40);
            $table->string('bai_associado', 30);
            $table->string('cep_associado', 8);
            $table->string('cid_associado', 40);
            $table->char('uf_associado', 2);
            $table->string('cel_associado', 15);
            $table->string('email_associado', 50);
            $table->string('sen_associado', 64);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associados');
    }
};
