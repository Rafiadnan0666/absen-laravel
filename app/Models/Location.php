<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_lokasi', 'latitude', 'longitude', 'radius_meter'])]
class Location extends Model
{
    use HasFactory;

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
