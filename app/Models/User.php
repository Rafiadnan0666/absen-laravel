<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
    'nama_lengkap', 'email', 'password', 'no_hp', 'alamat',
    'job_title_id', 'department_id', 'role_id',
    'tipe_gaji', 'jumlah_gaji', 'tanggal_masuk',
    'status_akun', 'face_embedding'
])]
#[Hidden(['password', 'remember_token', 'face_embedding'])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'face_embedding' => 'array',
            'tanggal_masuk' => 'date',
            'jumlah_gaji' => 'decimal:2',
        ];
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function shifts()
    {
        return $this->hasMany(UserShift::class);
    }

    public function shift()
    {
        return $this->hasOne(UserShift::class)->whereDate('tanggal_shift', today())->with('shift');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function reimbursements()
    {
        return $this->hasMany(Reimbursement::class);
    }

    public function faceLogs()
    {
        return $this->hasMany(FaceLog::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'dibuat_oleh');
    }

    /**
     * Check if the user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role && $this->role->nama_role === $role;
    }

    public function approvedLeaves()
    {
        return $this->hasMany(Leave::class, 'approved_by');
    }

    public function approvedReimbursements()
    {
        return $this->hasMany(Reimbursement::class, 'approved_by');
    }
}
