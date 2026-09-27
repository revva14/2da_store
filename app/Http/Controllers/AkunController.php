<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function biodata()
    {
        $user = auth()->user();
        return view('biodata', compact('user'));
    }

    public function updateBiodata(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'birthdate' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:30'],
            'delivery' => ['nullable', 'string', 'max:2000'],
        ]);

        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;
        $user->birthdate = $data['birthdate'] ?? null;
        $user->gender = $data['gender'] ?? null;
        $user->delivery_preference = $data['delivery'] ?? null;
        $user->save();

        return response()->json([
            'ok' => true,
            'message' => 'Data profil berhasil diperbarui.',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'birthdate' => $user->birthdate,
                'gender' => $user->gender,
                'delivery' => $user->delivery_preference,
            ],
        ]);
    }
}
