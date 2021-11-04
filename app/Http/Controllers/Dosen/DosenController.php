<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Str;

class DosenController extends Controller
{
    public function getKelas($id)
    {
        $data = Kelas::where('dosen', $id)->get();

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
        $mahasiswa = Enroll::where('kode_kelas', $kode)->get()->count();
        return response()->json([
            'message' => 'berhasil',
            'detail' => $data,
            'materi' => $materi,
            'tugas' => $tugas,
            'kuis' => $kuis,
            'mahasiswa' => $mahasiswa,
        ], 200);
    }

    public function buatKelas(Request $req)
    {
        $kode = Str::random(7);
        $k = new Kelas();
        $k->kode = $kode;
        $k->nama_kelas = $req->nama;
        $k->deskripsi = $req->deskripsi;
        $k->dosen = $req->dosen;
        try {
            $k->save();

            return response()->json([
                'message' => 'berhasil',
                'kode' => $kode
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'gagal'
            ], 400);
        }
    }

    public function uploadTugas(Request $req)
    {
        $t = new Tugas();
        $t->kode_kelas = $req->kode;
        $t->nama_tugas = $req->judul;
        $t->deskripsi = $req->deskripsi;
        $t->save();
        return response()->json([
            'cek' => $req->all()
        ], 200);
    }

    public function getMateri($kode)
    {
        $materi = Materi::where('kode_kelas', $kode)->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarMateri' => $materi
        ], 200);
    }

    public function uploadMateri(Request $req)
    {
        $file = $req->file('file');
        $file->storeAs('public/materi', md5($req->kode).'.'.$file->getClientOriginalExtension());
        $filename = md5($req->kode).'.'.$file->getClientOriginalExtension();

        $m = new Materi();
        $m->kode_kelas = $req->kode;
        $m->judul = $req->judul;
        $m->deskripsi = $req->deskripsi;
        $m->file = $filename;
        $m->save();

        return response()->json([
            'message' => 'berhasil',
            'data' => $req->all()
        ], 200);
    }

    public function getKuis($kode)
    {
        $kuis = Kuis::where('kode_kelas', $kode)->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarKuis' => $kuis
        ], 200);
    }

    public function uploadKuis(Request $req)
    {
        $file = $req->file('file');
        $file->storeAs('public/kuis', md5($req->kode).'.'.$file->getClientOriginalExtension());
        $filename = md5($req->kode).'.'.$file->getClientOriginalExtension();

        $m = new Kuis();
        $m->kode_kelas = $req->kode;
        $m->judul = $req->judul;
        $m->instruksi = $req->instruksi;
        $m->file = $filename;
        $m->save();

        return response()->json([
            'message' => 'berhasil',
            'data' => $req->all()
        ], 200);
    }
}
