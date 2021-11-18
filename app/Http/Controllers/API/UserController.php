<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\KuisTerkumpul;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\TugasMasuk;
use App\Models\User;
use Carbon\Carbon;
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

    public function getMateri($kode)
    {
        $materi = Materi::where('kode_kelas', $kode)->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarMateri' => $materi
        ], 200);
    }

    public function getTugas($kode)
    {
        $tugas = Tugas::where('kode_kelas', $kode)->get();

        return response()->json([
            'message' => 'berhasil',
            'daftarTugas' => $tugas
        ], 200);
    }

    public function getDetailTugas($kode, $id)
    {
        $dataTugas = Tugas::find($id);

        // cek deadline
        if (Carbon::parse($dataTugas->deadline)->isPast()) {
            return response()->json([
                'message' => 'telat',
                'detailTugas' => $dataTugas
            ], 200);
        }

        return response()->json([
            'message' => 'berhasil',
            'detailTugas' => $dataTugas
        ], 200);
    }

    public function cekTugas($kode, $id, $uploader)
    {
        $tugas = TugasMasuk::where('id_tugas', $id)->where('uploader', $uploader)->with('nilai')->first();
        if ($tugas) {
            return response()->json([
                'message' => 'Tugas Ada',
                'nilai' => $tugas->nilai ? $tugas->nilai->nilai : ''
            ], 200);
        } else {
            return response()->json([
                'message' => 'Tugas Tidak Ada',
            ], 200);
        }
    }

    public function uploadTugas(Request $req, $kode, $id)
    {
        $cekTugas = TugasMasuk::where('id_tugas', $id)->where('uploader', $req->uploader)->first();
        if ($cekTugas) {
            return response()->json([
                'message' => 'Tugas sudah dikumpul sebelumnya'
            ], 401);
        }
        $file = $req->file('file');
        $file->storeAs('tugas/'.$id, md5($req->uploader).'.'.$file->getClientOriginalExtension(), 'public_uploads');
        $filename = md5($req->uploader).'.'.$file->getClientOriginalExtension();

        $t = new TugasMasuk();
        $t->id_tugas = $id;
        $t->uploader = $req->uploader;
        $t->file = $filename;
        $t->save();

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

    public function getDetailKuis($kode, $id)
    {
        $dataKuis = Kuis::find($id);

        // cek deadline
        if (Carbon::parse($dataKuis->deadline)->isPast()) {
            return response()->json([
                'message' => 'telat',
                'detailTugas' => $dataKuis
            ], 200);
        }

        return response()->json([
            'message' => 'berhasil',
            'detailKuis' => $dataKuis
        ], 200);
    }

    public function cekKuis($kode, $id, $uploader)
    {
        $tugas = KuisTerkumpul::where('id_kuis', $id)->where('uploader', $uploader)->with('nilai')->first();
        if ($tugas) {
            return response()->json([
                'message' => 'Kuis Ada',
                'nilai' => $tugas->nilai ? $tugas->nilai->nilai : ''
            ], 200);
        } else {
            return response()->json([
                'message' => 'Kuis Tidak Ada',
            ], 200);
        }
    }

    public function kumpulKuis(Request $req, $kode, $id)
    {
        $cekKuis = KuisTerkumpul::where('id_kuis', $id)->where('uploader', $req->uploader)->first();
        if ($cekKuis) {
            return response()->json([
                'message' => 'Kuis sudah dikumpul sebelumnya'
            ], 401);
        }
        $file = $req->file('file');
        $file->storeAs('kuis/'.$id, md5($req->uploader).'.'.$file->getClientOriginalExtension(), 'public_uploads');
        $filename = md5($req->uploader).'.'.$file->getClientOriginalExtension();

        $t = new KuisTerkumpul();
        $t->id_kuis = $id;
        $t->uploader = $req->uploader;
        $t->file = $filename;
        $t->save();

        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }

    public function updateProfile(Request $req)
    {
        $u = User::find($req->id);
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
