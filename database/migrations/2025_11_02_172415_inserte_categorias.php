<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('categorias')->insert([
            ['nom_categoria' => 'Alimentação'],
            ['nom_categoria' => 'Roupas e Acessórios'],
            ['nom_categoria' => 'Eletrônicos'],
            ['nom_categoria' => 'Beleza e Saúde'],
            ['nom_categoria' => 'Supermercado'],
            ['nom_categoria' => 'Serviços'],
            ['nom_categoria' => 'Educação'],
            ['nom_categoria' => 'Entretenimento'],
        ]);
    }

    public function down(): void
    {
        DB::table('categorias')->whereIn('nom_categoria', [
            'Alimentação',
            'Roupas e Acessórios',
            'Eletrônicos',
            'Beleza e Saúde',
            'Supermercado',
            'Serviços',
            'Educação',
            'Entretenimento'
        ])->delete();
    }
};
