<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobTitleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_job_title' => 'required|string|max:255|unique:job_titles,nama_job_title',
            'deskripsi' => 'nullable|string',
            'gaji_min' => 'nullable|numeric|min:0',
            'gaji_max' => 'nullable|numeric|min:0|gte:gaji_min',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_job_title.required' => 'Nama job title wajib diisi.',
            'nama_job_title.unique' => 'Nama job title sudah ada.',
            'gaji_max.gte' => 'Gaji maksimum harus lebih besar dari gaji minimum.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}