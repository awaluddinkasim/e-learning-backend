<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;
    protected $table = 'materi';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('D MMMM YYYY');
    }
}
