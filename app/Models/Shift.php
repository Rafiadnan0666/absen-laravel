<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['nama_shift', 'jam_masuk', 'jam_pulang', 'toleransi_telat_menit'];

    public function userShifts()
    {
        return $this->hasMany(UserShift::class);
    }
}
