<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'tipe_log', 'waktu_log', 'latitude', 'longitude', 'jarak_meter', 'foto_path', 'device'])]
class AttendanceLog extends Model
{
    use HasFactory;

    protected $casts = [
        'waktu_log' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
