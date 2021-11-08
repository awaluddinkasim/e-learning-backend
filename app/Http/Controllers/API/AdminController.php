<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getUsers($tipe)
    {
        switch ($tipe) {
            case 'user':
                $users = User::all();
                break;

            case 'dosen':
                $users = Dosen::all();
                break;

            default:
                $users = [];
                break;
        }

        return response()->json([
            'message' => "berhasil",
            'users' => $users
        ], 200);
    }

    public function getUser($tipe, $id)
    {
        switch ($tipe) {
            case 'user':
                $user = User::find($id);
                break;

            case 'dosen':
                $user = Dosen::find($id);
                break;

            default:
                $user = [];
                break;
        }

        return response()->json([
            'message' => "berhasil",
            'user' => $user
        ], 200);
    }

    public function createUser(Request $req, $tipe)
    {
        try {
            switch ($tipe) {
                case 'user':
                    $user = new User();
                    $user->username = $req->username;
                    $user->name = $req->name;
                    $user->password = bcrypt($req->password);
                    $user->prodi = $req->prodi;
                    $user->jk = $req->jk;
                    $user->save();
                    break;

                case 'dosen':
                    $user = new Dosen();
                    $user->username = $req->username;
                    $user->name = $req->name;
                    $user->password = bcrypt($req->password);
                    $user->jk = $req->jk;
                    $user->prodi = $req->prodi;
                    $user->save();
                    break;
            }
            return response()->json([
                'message' => 'berhasil',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal',
                'data' => $req->all(),
            ], 400);
        }
    }

    public function updateUser(Request $req, $tipe, $id)
    {
        try {
            switch ($tipe) {
                case 'user':
                    $user = User::find($id);
                    $user->username = $req->username;
                    $user->name = $req->name;
                    if ($req->password) {
                        $user->password = bcrypt($req->password);
                    }
                    $user->prodi = $req->prodi;
                    $user->jk = $req->jk;
                    $user->save();
                    break;

                case 'dosen':
                    $user = Dosen::find($id);
                    $user->username = $req->username;
                    $user->name = $req->name;
                    if ($req->password) {
                        $user->password = bcrypt($req->password);
                    }
                    $user->jk = $req->jk;
                    $user->prodi = $req->prodi;
                    $user->save();
                    break;
            }
            return response()->json([
                'message' => 'berhasil',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal',
                'data' => $req->all(),
            ], 400);
        }
    }

    public function deleteUser($tipe, $id)
    {
        try {
            switch ($tipe) {
                case 'user':
                    User::find($id)->delete();
                    break;

                case 'dosen':
                    Dosen::find($id)->delete();
                    break;
            }

            return response()->json([
                'message' => 'berhasil',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal',
            ], 400);

        }
    }
}
