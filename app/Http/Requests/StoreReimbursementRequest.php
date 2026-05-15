<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReimbursementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori' => 'required|in:medical,transportation,meal,equipment,other',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal' => 'required|date|before_or_equal:today',
            'deskripsi' => 'required|string|min:10',
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori.required' => 'Kategori wajib dipilih.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.min' => 'Jumlah minimal Rp 1.000.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
            'bukti.required' => 'Bukti transaksi wajib diupload.',
            'bukti.max' => 'File bukti maksimal 5MB.',
            'bukti.mimes' => 'Format file harus JPG, PNG, atau PDF.',
        ];
    }
}