<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasMasuk extends Model
{
    protected $table = 'tugas_masuk';
    protected $with = ['mahasiswa'];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'uploader', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('D MMMM YYYY');
    }

    public function nilai()
    {
        return $this->hasOne(NilaiTugas::class, 'id_tugas');
    }

}
