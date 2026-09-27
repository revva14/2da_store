<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    /**
     * Nama bulan Indonesia, biar format tanggal "14 Jan 2024" / "10 Okt 2023"
     * tetap sama persis kayak desain aslinya tanpa perlu locale Carbon.
     */
    private const BULAN = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
        7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
    ];

    public function index(): View
    {
        $users = User::orderByDesc('created_at')->get();

        $pengguna = $users->map(function (User $u) {
            return [
                'id'     => $u->id,
                'nama'   => $u->name,
                'ini'    => $this->initials($u->name),
                'foto'   => $u->photo,
                'email'  => $u->email,
                'hp'     => $u->phone ?: '-',
                'root'   => (bool) $u->is_root,
                'admin'  => (bool) $u->is_admin,
                'reg'    => $u->created_at->format('d') . ' ' . self::BULAN[(int) $u->created_at->format('n')] . ' ' . $u->created_at->format('Y'),
                'status' => $u->is_blocked ? 'blok' : 'aktif',
                'blok'   => (bool) $u->is_blocked,
            ];
        })->toArray();

        return view('admin.pengguna', array_merge(
            compact('pengguna'),
            $this->statistik($users)
        ));
    }

    /**
     * Hitung 4 kartu statistik di atas halaman dari data users (dan transaksi)
     * yang sungguhan, ganti angka hardcode (1.240 / 895 / +74 / 2) yang lama.
     *
     * Catatan asumsi (silakan koreksi kalau beda dengan maksud desain aslinya):
     * - "Pelanggan" = user yang bukan admin & bukan root.
     * - "Pengguna Aktif Bulan Ini" = pelanggan yang punya minimal 1 transaksi
     *   sejak awal bulan berjalan (butuh relasi transaksi() di model User).
     * - "Pelanggan Baru Sign-up" dihitung 7 hari terakhir (bukan kalender minggu).
     */
    private function statistik($users): array
    {
        $sekarang     = now();
        $awalBulanIni = $sekarang->copy()->startOfMonth();
        $awalBulanLalu = $sekarang->copy()->subMonthNoOverflow()->startOfMonth();
        $akhirBulanLalu = $awalBulanIni->copy()->subSecond();
        $seminggu     = $sekarang->copy()->subDays(7);

        $pelanggan = $users->filter(fn (User $u) => ! $u->is_admin && ! $u->is_root);

        $totalPelanggan = $pelanggan->count();

        $pelangganBulanIni  = $pelanggan->filter(fn (User $u) => $u->created_at->greaterThanOrEqualTo($awalBulanIni))->count();
        $pelangganBulanLalu = $pelanggan->filter(fn (User $u) => $u->created_at->between($awalBulanLalu, $akhirBulanLalu))->count();

        $pertumbuhanPelanggan = $pelangganBulanLalu > 0
            ? (int) round((($pelangganBulanIni - $pelangganBulanLalu) / $pelangganBulanLalu) * 100)
            : ($pelangganBulanIni > 0 ? 100 : 0);

        $penggunaAktif = User::where('is_admin', false)
            ->where('is_root', false)
            ->whereHas('transaksi', function ($q) use ($awalBulanIni) {
                $q->where('created_at', '>=', $awalBulanIni);
            })
            ->count();

        $retensiPersen = $totalPelanggan > 0
            ? round(($penggunaAktif / $totalPelanggan) * 100, 1)
            : 0.0;

        $baruMingguIni = $pelanggan->filter(fn (User $u) => $u->created_at->greaterThanOrEqualTo($seminggu))->count();

        $totalAdmin = $users->filter(fn (User $u) => $u->is_admin || $u->is_root)->count();

        // Isi bar progres kartu pertama sekadar indikator visual (retensi, dibatasi 0-100)
        $progPersen = (int) max(0, min(100, $retensiPersen));

        return compact(
            'totalPelanggan',
            'pertumbuhanPelanggan',
            'penggunaAktif',
            'retensiPersen',
            'baruMingguIni',
            'totalAdmin',
            'progPersen'
        );
    }

    /**
     * PATCH /admin/pengguna/{user}/role
     * Body JSON: { "admin": true|false }
     */
    public function updateRole(Request $request, User $user): JsonResponse
    {
        if ($user->is_root) {
            return response()->json(['message' => 'Akun root tidak bisa diubah rolenya.'], 403);
        }

        if ($user->id === $request->user()?->id) {
            return response()->json(['message' => 'Tidak bisa mengubah role akun sendiri.'], 422);
        }

        $data = $request->validate([
            'admin' => ['required', 'boolean'],
        ]);

        $user->is_admin = $data['admin'];
        $user->save();

        return response()->json([
            'ok'    => true,
            'admin' => (bool) $user->is_admin,
        ]);
    }

    /**
     * PATCH /admin/pengguna/{user}/blokir
     * Body JSON: { "blokir": true|false }
     */
    public function updateBlokir(Request $request, User $user): JsonResponse
    {
        if ($user->is_root) {
            return response()->json(['message' => 'Akun root tidak bisa diblokir.'], 403);
        }

        if ($user->id === $request->user()?->id) {
            return response()->json(['message' => 'Tidak bisa memblokir akun sendiri.'], 422);
        }

        $data = $request->validate([
            'blokir' => ['required', 'boolean'],
        ]);

        $user->is_blocked = $data['blokir'];
        $user->save();

        return response()->json([
            'ok'     => true,
            'blokir' => (bool) $user->is_blocked,
        ]);
    }

    private function initials(string $name): string
    {
        $words = preg_split('/\s+/', trim($name));
        $first = mb_strtoupper(mb_substr($words[0] ?? '', 0, 1));
        $second = isset($words[1]) ? mb_strtoupper(mb_substr($words[1], 0, 1)) : '';

        return $first . $second;
    }
}