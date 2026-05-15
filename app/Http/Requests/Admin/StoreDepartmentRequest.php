<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_department' => 'required|string|max:255|unique:departments,nama_department',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_department.required' => 'Nama department wajib diisi.',
            'nama_department.unique' => 'Nama department sudah ada.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}