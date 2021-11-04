<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $with = ['tugasMasuk'];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('D MMMM YYYY');
    }

    public function tugasMasuk()
    {
        return $this->hasMany(TugasMasuk::class, 'id_tugas');
    }
}
