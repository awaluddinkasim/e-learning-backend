<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $with = ['daftarTugas'];

    public function daftarTugas()
    {
        return $this->hasMany(Tugas::class, 'kode_kelas', 'kode');
    }

    public function enrollment()
    {
        return $this->hasMany(Enroll::class, 'kode_kelas', 'kode');
    }
}
