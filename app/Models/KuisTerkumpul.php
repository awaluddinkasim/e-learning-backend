<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisTerkumpul extends Model
{
    use HasFactory;
    protected $table = 'kuis_attachment';
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
        return $this->hasOne(NilaiKuis::class, 'id_kuis');
    }
}
