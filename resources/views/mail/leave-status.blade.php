<x-mail::message>
# Leave request {{ $status }}

Hi {{ $leave->user->nama_lengkap }},

Your leave request has been **{{ $status }}**.

- **Type:** {{ ucfirst($leave->jenis_cuti) }}
- **Dates:** {{ $leave->tanggal_mulai->format('d M Y') }} – {{ $leave->tanggal_selesai->format('d M Y') }}
- **Reason:** {{ $leave->alasan }}

You can review the request in your leave history.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
