<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();

            // Siapa yang mengulas. Nullable karena data lama / ulasan tamu
            // mungkin tidak punya akun terdaftar.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Produk yang diulas (opsional, untuk dihubungkan ke tabel products nanti).
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();

            $table->string('nama');
            $table->string('inisial', 3)->nullable();

            // Grup kategori dipakai untuk filter di halaman testimoni user
            // (corndog, cireng, goreng, roti, minuman, dll).
            $table->string('kategori')->nullable();

            $table->unsignedTinyInteger('rating');
            $table->text('komentar');
            $table->string('foto')->nullable();

            $table->string('no_pesanan')->nullable();
            $table->json('item_pesanan')->nullable();
            $table->unsignedInteger('helpful_count')->default(0);

            $table->boolean('is_pinned')->default(false);

            $table->text('balasan')->nullable();
            $table->timestamp('balasan_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};