<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;
    protected $table = 'kuis';
    protected $with = ['terkumpul'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('D MMMM YYYY');
    }

    public function terkumpul()
    {
        return $this->hasMany(KuisTerkumpul::class, 'id_kuis');
    }
}
