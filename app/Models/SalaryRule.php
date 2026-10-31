<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRule extends Model
{
    use HasFactory;

    protected $fillable = ['tipe_gaji', 'rate_lembur', 'penalti_telat_per_menit', 'penalti_tidak_hadir'];

    protected $casts = [
        'rate_lembur' => 'decimal:2',
        'penalti_telat_per_menit' => 'decimal:2',
        'penalti_tidak_hadir' => 'decimal:2',
    ];
}
