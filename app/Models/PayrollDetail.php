<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['payroll_id', 'tipe', 'jumlah', 'deskripsi'])]
class PayrollDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
