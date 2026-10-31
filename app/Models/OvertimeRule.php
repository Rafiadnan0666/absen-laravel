<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeRule extends Model
{
    use HasFactory;

    protected $fillable = ['minimal_jam', 'multiplier'];

    protected $casts = [
        'minimal_jam' => 'decimal:2',
        'multiplier' => 'decimal:2',
    ];
}
