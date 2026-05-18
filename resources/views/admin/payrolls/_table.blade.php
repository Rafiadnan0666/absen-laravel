@forelse($payrolls as $payroll)
<tr>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $payroll->id }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $payroll->user->nama_lengkap ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-green-600">+ Rp {{ number_format($payroll->total_lembur ?? 0, 0, ',', '.') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-red-600">- Rp {{ number_format($payroll->total_potongan ?? 0, 0, ',', '.') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
      @if($payroll->status_pembayaran == 'paid') bg-gradient-to-tl from-green-600 to-lime-400
      @else bg-gradient-to-tl from-blue-600 to-indigo-500 @endif">
      {{ strtoupper($payroll->status_pembayaran) }}
    </span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.payrolls.show', $payroll) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
    <a href="{{ route('admin.payrolls.edit', $payroll) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 text-white rounded-2xl">Edit</a>
    <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Delete</button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="9" class="p-4 text-center text-slate-400">No payroll records found</td>
</tr>
@endforelse
</tbody></table>
<div class="p-4">
{{ $payrolls->links() }}
</div>
