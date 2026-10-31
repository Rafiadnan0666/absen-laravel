<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'periode_mulai', 'periode_selesai',
        'gaji_pokok', 'total_lembur', 'total_potongan',
        'bonus', 'total_gaji', 'status_pembayaran',
    ];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_selesai' => 'date',
        'gaji_pokok' => 'decimal:2',
        'total_lembur' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_gaji' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
