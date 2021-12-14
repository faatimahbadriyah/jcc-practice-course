<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $data = [
            'message' => 'login berhasil, session tersimpan',
            'data' => [],
        ];
        if (is_null($user)) {
            $data['message'] = 'login gagal: user tidak ditemukan';
            return response()->json($data, 400);
        }

        if (!Hash::check($request['password'], $user->password)) {
            $data['message'] = 'login gagal: password salah';
            return response()->json($data, 400);
        }

        auth()->login($user);

        $data['data'] = auth()->user();
        return response()->json($data, 200);
    }
}
