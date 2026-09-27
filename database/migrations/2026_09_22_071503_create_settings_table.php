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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Profil & Identitas Gerai
            $table->string('nama_toko')->default('2DA Store');
            $table->string('whatsapp')->nullable();
            $table->string('tagline')->nullable();
            $table->text('alamat')->nullable();
            $table->string('catatan_patokan')->nullable();
            $table->string('logo_path')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Metode Pembayaran
            $table->boolean('qris_aktif')->default(true);
            $table->boolean('tunai_aktif')->default(true);
            $table->boolean('transfer_aktif')->default(false);

            // Jam Operasional
            $table->boolean('status_buka')->default(true);
            $table->time('jam_buka_weekday')->nullable();
            $table->time('jam_tutup_weekday')->nullable();
            $table->time('jam_buka_weekend')->nullable();
            $table->time('jam_tutup_weekend')->nullable();
            $table->date('libur_mulai')->nullable();
            $table->date('libur_selesai')->nullable();

            // Printer Thermal & Dapur
            $table->boolean('auto_accept')->default(true);
            $table->boolean('notif_suara')->default(true);
            $table->enum('ukuran_kertas', ['58', '80'])->default('80');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};