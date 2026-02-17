<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabletUser; 
use Illuminate\Support\Facades\Hash;

class TabletAuthController extends Controller
{
    // LOGIN KHUSUS TABLET (Cek ke tabel 'tablet_users')
    public function login(Request $request)
    {
        // 1. Validasi Input (UBAH JADI EMAIL BIAR COCOK SAMA FLUTTER)
        $request->validate([
            'email' => 'required|email', 
            'password' => 'required',
        ]);

        // 2. Cari User pakai EMAIL
        $user = TabletUser::where('email', $request->email)->first();

        // 3. Cek Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Salah!',
            ], 401);
        }

        // 4. Create Token
        $token = $user->createToken('tablet_token')->plainTextToken;

        // 5. Response Sukses (STRUCTURE INI PENTING BUAT FLUTTER)
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            'data'    => [
                'access_token' => $token, // <--- Flutter nyarinya ini!
                'token_type'   => 'Bearer',
                'user'         => $user,  // Data user (nama_lengkap, email, dll)
            ]
        ], 200);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Berhasil']);
    }
}