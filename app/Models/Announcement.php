<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['judul', 'isi', 'dibuat_oleh'])]
class Announcement extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
