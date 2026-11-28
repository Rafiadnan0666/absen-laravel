<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_gaji',
        'rate_lembur',
        'gaji_per_hari',
        'gaji_per_jam',
        'penalti_telat_per_menit',
        'penalti_tidak_hadir',
        'penalti_alfa_per_hari',
        'penalti_pulang_cepat_per_menit',
    ];

    protected $casts = [
        'rate_lembur' => 'decimal:2',
        'gaji_per_hari' => 'decimal:2',
        'gaji_per_jam' => 'decimal:2',
        'penalti_telat_per_menit' => 'decimal:2',
        'penalti_tidak_hadir' => 'decimal:2',
        'penalti_alfa_per_hari' => 'decimal:2',
        'penalti_pulang_cepat_per_menit' => 'decimal:2',
    ];
}
