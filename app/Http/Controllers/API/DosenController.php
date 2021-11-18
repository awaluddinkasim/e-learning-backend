<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Enroll;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\KuisTerkumpul;
use App\Models\Materi;
use App\Models\NilaiKuis;
use App\Models\NilaiTugas;
use App\Models\Tugas;
use App\Models\TugasMasuk;
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
        $t->deadline = $req->deadline;
        $t->save();
        return response()->json([
            'cek' => $req->all()
        ], 200);
    }

    public function hapusTugas($id)
    {
        Tugas::find($id)->delete();
        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }

    public function getTugasMasuk($kode, $id)
    {
        $data = TugasMasuk::where('id_tugas', $id)->with('nilai')->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarTugas' => $data
        ], 200);
    }

    public function tugasNilai(Request $req)
    {
        $n = new NilaiTugas();
        $n->id_tugas = $req->id_tugas;
        $n->nilai = $req->nilai;
        $n->save();

        return response()->json([
            'message' => 'berhasil'
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
        $filename = md5($req->kode.Str::random(3)).'.'.$file->getClientOriginalExtension();
        $file->storeAs('materi', $filename, 'public_uploads');

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

    public function hapusMateri($id)
    {
        Materi::find($id)->delete();
        return response()->json([
            'message' => 'berhasil'
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
        $filename = md5($req->kode.Str::random(3)).'.'.$file->getClientOriginalExtension();
        $file->storeAs('kuis', $filename, 'public_uploads');

        $m = new Kuis();
        $m->kode_kelas = $req->kode;
        $m->judul = $req->judul;
        $m->instruksi = $req->instruksi;
        $m->deadline = $req->deadline;
        $m->file = $filename;
        $m->save();

        return response()->json([
            'message' => 'berhasil',
            'data' => $req->all()
        ], 200);
    }

    public function hapusKuis($id)
    {
        Kuis::find($id)->delete();
        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }

    public function getKuisMasuk($kode, $id)
    {
        $data = KuisTerkumpul::where('id_kuis', $id)->with('nilai')->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarKuis' => $data
        ], 200);
    }

    public function kuisNilai(Request $req)
    {
        $n = new NilaiKuis();
        $n->id_kuis = $req->id_kuis;
        $n->nilai = $req->nilai;
        $n->save();

        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }

    public function updateProfile(Request $req)
    {
        $u = Dosen::find($req->id);
        if ($u) {
            $u->name = $req->name;
            $u->jk = $req->jk;
            $u->prodi = $req->prodi;
            if ($req->password) {
                $u->password = bcrypt($req->password);
            }
            $u->save();

            return response()->json([
                'message' => 'berhasil'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Dosen tidak ditemukan',
            ], 404);
        }
    }
}
