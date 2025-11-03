<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comercios', function (Blueprint $table) {
            $table->string('cnpj_comercio', 20)->primary();
            $table->integer('id_categoria')->nullable();
            $table->string('raz_social_comercio', 50);
            $table->string('nom_fantasia_comercio', 30);
            $table->string('end_comercio', 40);
            $table->string('bai_comercio', 30);
            $table->string('cep_comercio', 8);
            $table->string('cid_comercio', 40);
            $table->char('uf_comercio', 2);
            $table->string('con_comercio', 15);
            $table->string('email_comercio', 50);
            $table->string('sen_comercio', 64);
            $table->timestamps();

            $table->foreign('id_categoria')
                ->references('id_categoria')->on('categorias');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comercios');
    }
};
