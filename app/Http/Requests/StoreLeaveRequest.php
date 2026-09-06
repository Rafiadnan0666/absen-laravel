<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('jenis_cuti')) {
            $this->merge([
                'tipe_cuti' => match ($this->input('jenis_cuti')) {
                    'sakit' => 'sakit',
                    'izin' => 'annual',
                    'tahunan' => 'annual',
                    'maternity' => 'annual',
                    'paternity' => 'annual',
                    'other' => 'unpaid',
                    default => $this->input('jenis_cuti'),
                },
            ]);
        }

        if ($this->filled('tanggal_akhir')) {
            $this->merge([
                'tanggal_selesai' => $this->input('tanggal_akhir'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'tipe_cuti' => 'required|in:sick,annual,unpaid',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|min:10',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'tipe_cuti.required' => 'Jenis cuti wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.required' => 'Tanggal akhir wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal akhir harus setelah tanggal mulai.',
            'alasan.required' => 'Alasan wajib diisi.',
            'alasan.min' => 'Alasan minimal 10 karakter.',
            'bukti.max' => 'File bukti maksimal 2MB.',
            'bukti.mimes' => 'Format file harus JPG, PNG, atau PDF.',
        ];
    }
}