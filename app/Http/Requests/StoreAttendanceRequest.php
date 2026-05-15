<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i:s',
            'jam_keluar' => 'nullable|date_format:H:i:s|after:jam_masuk',
            'status' => 'required|in:hadir,terlambat,alpha,izin,sakit',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Pegawai wajib dipilih.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk.',
            'status.required' => 'Status kehadiran wajib dipilih.',
        ];
    }
}