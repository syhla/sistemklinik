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
        Schema::table('pasiens', function (Blueprint $table) {
        $table->unsignedBigInteger('dokter_id')->nullable()->after('dokter_tujuan');
        $table->text('hasil_pemeriksaan')->nullable()->after('status');
        $table->text('resep_obat')->nullable()->after('hasil_pemeriksaan');
        $table->text('catatan')->nullable()->after('resep_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
        $table->dropColumn(['dokter_id', 'hasil_pemeriksaan', 'resep_obat', 'catatan']);
    });
    
    }
};
