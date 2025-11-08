<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE SEQUENCE IF NOT EXISTS cupons_id_promo_seq START 1 INCREMENT 1;');

        Schema::table('cupons', function (Blueprint $table) {
            $table->bigInteger('id_promo');
        });
    }

    public function down(): void
    {
        Schema::table('cupons', function (Blueprint $table) {
            $table->dropColumn('id_promo');
        });

        DB::statement('DROP SEQUENCE IF EXISTS cupons_id_promo_seq;');
    }
};
