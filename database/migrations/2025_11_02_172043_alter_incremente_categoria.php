<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('create sequence if not exists categorias_id_categoria_seq start 1 increment 1;');

        DB::statement('alter table categorias alter column id_categoria set default nextval(\'categorias_id_categoria_seq\');');

        DB::statement('select setval(\'categorias_id_categoria_seq\', coalesce((select max(id_categoria) from categorias), 0) + 1, false);');
    }

    public function down(): void
    {
        DB::statement('alter table categorias alter column id_categoria drop default;');

        DB::statement('drop sequence if exists categorias_id_categoria_seq;');
    }
};
