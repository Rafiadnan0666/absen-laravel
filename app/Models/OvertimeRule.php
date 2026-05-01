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
}
