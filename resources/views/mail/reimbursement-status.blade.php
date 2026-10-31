<x-mail::message>
# Reimbursement request {{ $status }}

Hi {{ $reimbursement->user->nama_lengkap }},

Your reimbursement request has been **{{ $status }}**.

- **Category:** {{ ucfirst($reimbursement->kategori) }}
- **Amount:** Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}
- **Description:** {{ $reimbursement->deskripsi }}

You can review the request in your reimbursement history.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
