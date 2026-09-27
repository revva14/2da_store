<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dipakai buat bedain akun biasa vs admin vs pemilik toko (root)
            $table->boolean('is_admin')->default(false)->after('password');
            $table->boolean('is_root')->default(false)->after('is_admin');
            $table->boolean('is_blocked')->default(false)->after('is_root');

            // Belum ada di form registrasi sekarang, tapi kolomnya disiapin
            // dulu supaya nanti gampang kalau mau nambah upload foto profil / no HP
            $table->string('phone')->nullable()->after('email');
            $table->string('photo')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'is_root', 'is_blocked', 'phone', 'photo']);
        });
    }
};