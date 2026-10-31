<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'isi', 'dibuat_oleh'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
