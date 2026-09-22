<?php

namespace App\Http\Controllers;

use App\Models\Pesanan; // sesuaikan nama model
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function detail($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        return view('pesanan.detail', compact('pesanan'));
    }
}