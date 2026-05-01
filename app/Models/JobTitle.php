<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_jabatan', 'deskripsi', 'default_gaji'])]
class JobTitle extends Model
{
    use HasFactory;

    protected $casts = [
        'default_gaji' => 'decimal:2',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
