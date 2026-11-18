
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_was', function (Blueprint $table) {
            $table->foreignId('penjual_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('pembeli_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('barang_id')
                ->nullable()
                ->constrained('barangs')
                ->cascadeOnDelete();

            $table->text('pesan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('chat_was', function (Blueprint $table) {
            $table->dropForeign(['penjual_id']);
            $table->dropForeign(['pembeli_id']);
            $table->dropForeign(['barang_id']);

            $table->dropColumn([
                'penjual_id',
                'pembeli_id',
                'barang_id',
                'pesan'
            ]);
        });
    }
};
