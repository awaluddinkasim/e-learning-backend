<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;
    protected $table = 'enroll';
    protected $with = ['kelas'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode');
    }
}
