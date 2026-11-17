<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambah data penjualan pada tabel barangs untuk fitur Laporan Pendapatan.
     * Semua kolom nullable supaya data lama tidak terpengaruh.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('nama_pembeli')->nullable()->after('status');
            $table->unsignedBigInteger('harga_jual')->nullable()->after('nama_pembeli');
            $table->date('terjual_pada')->nullable()->after('harga_jual');

            // Laporan selalu memfilter berdasarkan pemilik + status
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropColumn(['nama_pembeli', 'harga_jual', 'terjual_pada']);
        });
    }
};
