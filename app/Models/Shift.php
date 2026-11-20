<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_shift', 'jam_masuk', 'jam_pulang', 'toleransi_telat_menit', 'is_default'])]
class Shift extends Model
{
    use HasFactory;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function userShifts()
    {
        return $this->hasMany(UserShift::class);
    }

    public static function defaultShift(): ?self
    {
        return static::where('is_default', true)->first()
            ?? static::orderBy('id')->first();
    }
}