<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index(Request $request)
    {
        $query = Ulasan::with('product')->terbaru();

        if ($request->filled('rating')) {
            if ($request->rating === '1-2') {
                $query->whereIn('rating', [1, 2]);
            } else {
                $query->where('rating', (int) $request->rating);
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'belum') {
                $query->whereNull('balasan');
            } elseif ($request->status === 'sudah') {
                $query->whereNotNull('balasan');
            }
        }

        if ($request->filled('cari')) {
            $cari = $request->string('cari');
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhere('komentar', 'like', "%{$cari}%");
            });
        }

        $ulasan = $query->paginate(5)->withQueryString();

        $totalUlasan  = Ulasan::count();
        $rataRata     = round((float) Ulasan::avg('rating'), 1);
        $sudahDibalas = Ulasan::whereNotNull('balasan')->count();
        $belumDibalas = $totalUlasan - $sudahDibalas;
        $responseRate = $totalUlasan ? round($sudahDibalas / $totalUlasan * 100) : 0;

        $distribusi = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribusi[$i] = Ulasan::where('rating', $i)->count();
        }
        $ratingSatuDua = $distribusi[1] + $distribusi[2];

        return view('admin.ulasan', compact(
            'ulasan',
            'totalUlasan',
            'rataRata',
            'sudahDibalas',
            'belumDibalas',
            'responseRate',
            'distribusi',
            'ratingSatuDua'
        ));
    }

    // Kirim / perbarui balasan resmi toko untuk sebuah ulasan.
    public function balas(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'balasan' => 'required|string|max:1000',
        ]);

        $ulasan->update([
            'balasan'    => $request->input('balasan'),
            'balasan_at' => now(),
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function hapusBalasan(Ulasan $ulasan)
    {
        $ulasan->update([
            'balasan'    => null,
            'balasan_at' => null,
        ]);

        return back()->with('success', 'Balasan berhasil dihapus.');
    }

    // Toggle sematkan ulasan di beranda/testimoni (dipanggil via fetch/AJAX).
    public function togglePin(Ulasan $ulasan)
    {
        $ulasan->is_pinned = ! $ulasan->is_pinned;
        $ulasan->save();

        return response()->json(['is_pinned' => $ulasan->is_pinned]);
    }

    // Unduh rekap ulasan sebagai CSV.
    public function unduh()
    {
        $semua = Ulasan::terbaru()->get();

        $filename = 'rekap-ulasan-2da-store-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($semua) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Nama', 'Rating', 'Komentar', 'No. Pesanan', 'Tanggal', 'Status', 'Balasan Admin']);

            foreach ($semua as $u) {
                fputcsv($out, [
                    $u->nama,
                    $u->rating,
                    $u->komentar,
                    $u->no_pesanan ?? '-',
                    optional($u->created_at)->format('d M Y H:i'),
                    $u->sudah_dibalas ? 'Sudah dibalas' : 'Belum dibalas',
                    $u->balasan ?? '-',
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}