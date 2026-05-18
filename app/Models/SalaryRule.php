<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tipe_gaji', 'rate_lembur', 'penalti_telat_per_menit', 'penalti_tidak_hadir'])]
class SalaryRule extends Model
{
    use HasFactory;

    protected $casts = [
        'rate_lembur' => 'decimal:2',
        'penalti_telat_per_menit' => 'decimal:2',
        'penalti_tidak_hadir' => 'decimal:2',
    ];

    public function scopeByType($query, $tipeGaji)
    {
        return $query->where('tipe_gaji', $tipeGaji);
    }

    public static function getRuleForUser(User $user)
    {
        return static::where('tipe_gaji', $user->tipe_gaji)->first();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tipe_gaji', 'tipe_gaji');
    }
}
