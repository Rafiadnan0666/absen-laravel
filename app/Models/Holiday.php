<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_hari_libur', 'tanggal'])]
class Holiday extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function scopeThisMonth($query)
    {
        return $query->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', today())
            ->orderBy('tanggal');
    }

    public function scopeInRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }

    public static function isHoliday($date)
    {
        return static::whereDate('tanggal', $date)->exists();
    }

    public static function countInRange($start, $end)
    {
        return static::whereBetween('tanggal', [$start, $end])->count();
    }
}
