<x-mail::message>
# Payroll {{ $status }}

Hi {{ $payroll->user->nama_lengkap }},

Your payroll for **{{ $payroll->periode_mulai->format('d M Y') }} – {{ $payroll->periode_selesai->format('d M Y') }}** has been **{{ $status }}**.

- **Base salary:** Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}
- **Overtime:** Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}
- **Deductions:** Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}
- **Bonus:** Rp {{ number_format($payroll->bonus, 0, ',', '.') }}
- **Total:** Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}

@if($payroll->rejection_reason)
**Reason:** {{ $payroll->rejection_reason }}
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
