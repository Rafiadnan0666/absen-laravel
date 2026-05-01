<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id', 'tanggal', 'check_in', 'check_out',
    'status_hadir', 'jam_kerja', 'jam_lembur',
    'menit_telat', 'menit_pulang_cepat',
    'location_id', 'face_verified'
])]
class Attendance extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal' => 'date',
        'check_in' => 'datetime:H:i:s',
        'check_out' => 'datetime:H:i:s',
        'jam_kerja' => 'datetime:H:i:s',
        'jam_lembur' => 'datetime:H:i:s',
        'face_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
