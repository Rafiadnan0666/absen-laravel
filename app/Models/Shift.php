<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['nama_shift', 'jam_masuk', 'jam_pulang', 'toleransi_telat_menit', 'is_default'];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public static function defaultShift(): ?self
    {
        return static::where('is_default', true)->first()
            ?? static::orderBy('id')->first();
    }

    public function userShifts()
    {
        return $this->hasMany(UserShift::class);
    }
}
