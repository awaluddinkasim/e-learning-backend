<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Kelas;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function enroll(Request $req)
    {
        $checkKelas = Kelas::find($req->kodeKelas);
        if (!$checkKelas) {
            return response()->json([
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $checkEnrolled = Enroll::where('kode_kelas', $req->kodeKelas)->where('id_user', $req->idUser)->first();
        if ($checkEnrolled) {
            return response()->json([
                'message' => 'Kelas sudah terdaftar'
            ], 403);
        }
        $e = new Enroll();
        $e->kode_kelas = $req->kodeKelas;
        $e->id_user = $req->idUser;
        $e->save();

        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }

    public function getKelas($id)
    {
        $data = Enroll::where('id_user', $id)->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarKelas' => $data
        ], 200);
    }

    public function getDataKelas($kode)
    {
        $data = Kelas::find($kode);
        $materi = Materi::where('kode_kelas', $kode)->get()->count();
        $tugas = Tugas::where('kode_kelas', $kode)->get()->count();
        $kuis = Kuis::where('kode_kelas', $kode)->get()->count();
        return response()->json([
            'message' => 'berhasil',
            'detail' => $data,
            'materi' => $materi,
            'tugas' => $tugas,
            'kuis' => $kuis,
        ], 200);
    }
}
