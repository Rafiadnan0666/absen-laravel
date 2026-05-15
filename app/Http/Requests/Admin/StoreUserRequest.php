<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'role_id' => 'required|exists:roles,id',
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'jumlah_gaji' => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'department_id.required' => 'Department wajib dipilih.',
            'job_title_id.required' => 'Job title wajib dipilih.',
            'role_id.required' => 'Role wajib dipilih.',
            'tipe_gaji.required' => 'Tipe gaji wajib dipilih.',
            'jumlah_gaji.required' => 'Jumlah gaji wajib diisi.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
        ];
    }
}