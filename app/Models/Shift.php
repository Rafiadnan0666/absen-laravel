<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_shift', 'jam_masuk', 'jam_pulang', 'toleransi_telat_menit'])]
class Shift extends Model
{
    use HasFactory;

    public function userShifts()
    {
        return $this->hasMany(UserShift::class);
    }
}
