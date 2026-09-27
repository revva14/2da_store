<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('no_pesanan')->unique();
            $table->string('nama_penerima');
            $table->string('no_whatsapp', 30);
            $table->text('alamat');
            $table->text('catatan_driver')->nullable();
            $table->text('catatan_dapur')->nullable();
            $table->string('metode_pengiriman')->default('delivery');
            $table->string('label_pengiriman')->nullable();
            $table->string('metode_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->unsignedInteger('subtotal')->default(0);
            $table->unsignedInteger('ongkir')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->enum('status', ['baru','dapur','antar','selesai','batal'])->default('baru');
            $table->timestamps();
        });

        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi', 'id_transaksi')->cascadeOnDelete();
            $table->string('product_slug');
            $table->string('nama_produk');
            $table->unsignedInteger('harga')->default(0);
            $table->unsignedInteger('qty')->default(1);
            $table->json('opsi')->nullable();
            $table->unsignedInteger('subtotal')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
        Schema::dropIfExists('transaksi');
    }
};