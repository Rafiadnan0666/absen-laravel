<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['minimal_jam', 'multiplier'])]
class OvertimeRule extends Model
{
    use HasFactory;

    protected $casts = [
        'minimal_jam' => 'decimal:2',
        'multiplier' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('minimal_jam', '>', 0);
    }

    public static function calculateOvertimePay($overtimeHours, $hourlyRate)
    {
        $rule = static::active()->first();
        if (!$rule || $overtimeHours < $rule->minimal_jam) {
            return 0;
        }
        return $overtimeHours * $hourlyRate * $rule->multiplier;
    }
}
