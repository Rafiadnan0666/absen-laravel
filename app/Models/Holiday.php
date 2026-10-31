<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['nama_hari_libur', 'tanggal'];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
