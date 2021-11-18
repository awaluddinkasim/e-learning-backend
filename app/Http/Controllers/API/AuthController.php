<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginUser(Request $req)
    {
        $user = User::where('username', $req->username)->first();

        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('auth-user')->plainTextToken;

            $user->last_online = Carbon::now();
            $user->save();

            return response()->json([
                'message' => 'berhasil',
                'token' => $token,
                'user' => $user,
                'role' => 'user'
            ], 200);
        }

        return response()->json([
            'message' => 'Username atau Password salah'
        ], 401);
    }

    public function loginDosen(Request $req)
    {
        $user = Dosen::where('username', $req->username)->first();

        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('auth-dosen')->plainTextToken;

            $user->last_online = Carbon::now();
            $user->save();

            return response()->json([
                'message' => 'berhasil',
                'token' => $token,
                'user' => $user,
                'role' => 'dosen'
            ], 200);
        }

        return response()->json([
            'message' => 'Username atau Password salah'
        ], 401);
    }

    public function loginAdmin(Request $req)
    {
        if (Admin::all()->count() < 1) {
            $a = new Admin();
            $a->username = 'admin';
            $a->name = "Administrator";
            $a->password = bcrypt('admin');
            $a->save();
        }

        $user = Admin::where('username', $req->username)->first();

        if ($user && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('auth-admin')->plainTextToken;

            $user->last_online = Carbon::now();
            $user->save();

            return response()->json([
                'message' => 'berhasil',
                'token' => $token,
                'user' => $user,
                'role' => 'admin'
            ], 200);
        }

        return response()->json([
            'message' => 'Username atau Password salah'
        ], 401);
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout'
        ], 200);
    }
}
