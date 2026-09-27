<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        return view('testimoni', $this->data());
    }

    public function indexLogin()
    {
        return view('testimonilogin', $this->data());
    }

    // Tombol "Membantu" di kartu ulasan (AJAX).
    public function membantu(Ulasan $ulasan)
    {
        $ulasan->increment('helpful_count');

        return response()->json(['helpful_count' => $ulasan->helpful_count]);
    }

    // Data yang sama dipakai baik oleh testimoni.blade.php (sebelum login)
    // maupun testimonilogin.blade.php (setelah login), supaya keduanya
    // membaca dari sumber yang sama dengan halaman kelola ulasan admin.
    private function data(): array
    {
        $reviews = Ulasan::terbaru()->get()->map(function (Ulasan $u) {
            return [
                'id'       => $u->id,
                'type'     => $u->foto ? 'photo' : 'text',
                'img'      => $u->foto ? asset($u->foto) : null,
                'cat'      => $u->product->name ?? ucfirst($u->kategori ?? 'Menu'),
                'group'    => $u->kategori ?? 'lainnya',
                'rating'   => $u->rating,
                'icon'     => $u->icon,
                'time'     => $u->created_at->diffForHumans(),
                'initials' => $u->inisial,
                'green'    => $u->is_pinned,
                'name'     => $u->nama,
                'role'     => $u->product->name ?? 'Pelanggan 2DA Store',
                'text'     => $u->komentar,
                'helpful'  => $u->helpful_count,
                'order'    => $u->item_pesanan[0] ?? ($u->no_pesanan ?? '-'),
                'badge'    => $u->item_pesanan[0] ?? ($u->no_pesanan ?? '-'),
                'balasan'  => $u->balasan,
            ];
        });

        $totalAll   = $reviews->count();
        $totalPhoto = $reviews->where('type', 'photo')->count();
        $totalText  = $totalAll - $totalPhoto;

        return compact('reviews', 'totalAll', 'totalPhoto', 'totalText');
    }
}