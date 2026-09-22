<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function index()
    {
        return view('google');
    }

    public function redirect()
    {
        // Nantinya diisi logika Laravel Socialite
        return redirect()->route('login');
    }

    public function callback()
    {
        // Penanganan callback dari Google
        return redirect()->route('berandalogin');
    }
}