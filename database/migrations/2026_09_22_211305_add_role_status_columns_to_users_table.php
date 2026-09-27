<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nambah kolom yang dipakai halaman Kelola Akun & Pelanggan
     * (Admin/PenggunaController):
     *
     * - is_root    : akun pemilik/superadmin bawaan, tidak bisa diubah role
     *                atau diblokir lewat UI.
     * - is_admin   : true = tampil sebagai "Admin", false = "Pengguna".
     * - is_blocked : true = akun diblokir, tidak bisa login.
     *
     * Ditulis pakai Schema::hasColumn() supaya AMAN dijalankan meski
     * sebagian kolom sudah pernah dibuat lebih dulu (tidak akan error
     * "Duplicate column name").
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_root')) {
                $table->boolean('is_root')->default(false)->after('password');
            }

            if (! Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('is_root');
                $table->index('is_admin');
            }

            if (! Schema::hasColumn('users', 'is_blocked')) {
                $table->boolean('is_blocked')->default(false)->after('is_admin');
                $table->index('is_blocked');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropIndex(['is_admin']);
            }
            if (Schema::hasColumn('users', 'is_blocked')) {
                $table->dropIndex(['is_blocked']);
            }

            $kolom = array_filter(
                ['is_root', 'is_admin', 'is_blocked'],
                fn ($k) => Schema::hasColumn('users', $k)
            );

            if ($kolom) {
                $table->dropColumn($kolom);
            }
        });
    }
};