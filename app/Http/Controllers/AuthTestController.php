<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthTestController extends Controller
{
    public function register(Request $request) {
        // Ganti Validator manual dengan validasi simpel agar tidak error di Web
        if (!$request->name || !$request->email || !$request->password || !$request->target_pt) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak lengkap!'], 400);
        }

        try {
            $pt = $request->target_pt; 

            // Cek apakah email sudah ada
            $exists = DB::connection($pt)->table('test_accounts')->where('email', $request->email)->exists();
            if ($exists) {
                return response()->json(['status' => 'error', 'message' => 'Email sudah terdaftar!'], 409);
            }

            DB::connection($pt)->table('test_accounts')->insert([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Registrasi Berhasil'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request) {
        // Validasi input simpel
        if (!$request->email || !$request->password || !$request->target_pt) {
            return response()->json(['status' => 'error', 'message' => 'Email, Password, dan PT wajib diisi'], 400);
        }

        try {
            $pt = $request->target_pt;
            
            // Mencari user di database yang dipilih
            $user = DB::connection($pt)->table('test_accounts')->where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Login Berhasil',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'company' => $pt
                    ]
                ], 200);
            }
            
            return response()->json(['status' => 'error', 'message' => 'Email atau Password salah'], 401);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()], 500);
        }
    }
}