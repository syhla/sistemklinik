<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('obat_diberikan')->nullable();
            $table->integer('jumlah_obat')->nullable();
            $table->string('apoteker_nama')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['obat_diberikan', 'jumlah_obat', 'apoteker_nama']);
        });
    }
};
