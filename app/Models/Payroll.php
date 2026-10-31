<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use Auditable;
    use HasFactory;

    protected $fillable = [
        'user_id', 'periode_mulai', 'periode_selesai',
        'gaji_pokok', 'total_lembur', 'total_potongan',
        'bonus', 'total_gaji', 'status_pembayaran',
        'confirmed_by', 'confirmed_at', 'paid_at', 'rejection_reason',
    ];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_selesai' => 'date',
        'gaji_pokok' => 'decimal:2',
        'total_lembur' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'bonus' => 'decimal:2',
        'total_gaji' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }

    public function isPaid(): bool
    {
        return $this->status_pembayaran === 'paid';
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed_at !== null;
    }

    public function canBeConfirmed(): bool
    {
        return ! $this->isPaid() && ! $this->isConfirmed();
    }

    public function canBePaid(): bool
    {
        return $this->isConfirmed() && ! $this->isPaid();
    }
}
