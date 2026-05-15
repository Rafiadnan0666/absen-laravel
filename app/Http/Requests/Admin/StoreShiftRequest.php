<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_shift' => 'required|string|max:255|unique:shifts,nama_shift',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
            'tolerance_minutes' => 'nullable|integer|min:0|max:60',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_shift.required' => 'Nama shift wajib diisi.',
            'nama_shift.unique' => 'Nama shift sudah ada.',
            'jam_masuk.required' => 'Jam masuk wajib diisi.',
            'jam_keluar.required' => 'Jam keluar wajib diisi.',
            'jam_keluar.after' => 'Jam keluar harus lebih晚 dari jam masuk.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}