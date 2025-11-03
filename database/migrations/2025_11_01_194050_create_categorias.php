<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->integer('id_categoria')->primary();
            $table->string('nom_categoria', 25);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
