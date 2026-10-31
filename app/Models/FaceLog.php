<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'foto_path', 'confidence_score', 'is_match'];

    protected $casts = [
        'confidence_score' => 'decimal:2',
        'is_match' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
