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
}
