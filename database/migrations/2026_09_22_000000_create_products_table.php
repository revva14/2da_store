<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // dipakai di URL /produklogin?p=slug DAN sebagai key data di menulogin.blade.php
            $table->string('slug')->unique();

            // ===== field yang dipakai halaman USER (menulogin.blade.php) =====
            $table->string('name');                 // nama produk
            $table->text('desc')->nullable();       // deskripsi
            $table->string('cats');                 // 'gurih' | 'manis' | 'minuman'
            $table->string('img')->nullable();      // nama file di public/images
            $table->unsignedInteger('price')->default(0);
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->string('reviews')->default('0'); // string, bukan integer -> data lama ada format "340+"

            // ===== field tambahan yang dipakai halaman ADMIN (menu.blade.php) =====
            $table->string('sku')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_hot')->default(false);   // badge "hot/favorit"
            $table->boolean('is_active')->default(true); // status jual (switch di admin)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};