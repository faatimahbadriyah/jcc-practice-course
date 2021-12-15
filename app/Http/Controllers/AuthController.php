<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request['email'])->first();
            $data = [
                'message' => 'login berhasil, session tersimpan',
                'data' => [],
            ];
            if (is_null($user)) {
                $data['message'] = 'login gagal: user tidak ditemukan';
                Log::error($data['message'], ['data' => $request['email']]);
                return response()->json($data, 400);
            }

            if (!Hash::check($request['password'], $user->password)) {
                $data['message'] = 'login gagal: password salah';
                Log::error($data['message'], ['data' => $request['email']]);
                return response()->json($data, 400);
            }

            auth()->login($user);

            $data['data'] = auth()->user();
            Log::info($data['message'], $user->toArray());
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), []);
            return response()->json($data, 400);
        }
    }

    public function logout()
    {
        $data['data'] = [];
        try {
            auth()->logout();
            $data['message'] = 'logout berhasil: session dihapus';
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json($data, 400);
        }
    }

    public function user()
    {
        try {
            $data = auth()->aku();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
            return response()->json($data, 400);
        }
    }
}
