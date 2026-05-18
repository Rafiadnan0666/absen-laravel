@forelse($reimbursements as $reimbursement)
<tr>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <input type="checkbox" class="bulk-checkbox rounded border-slate-300 text-purple-600 focus:ring-purple-500" value="{{ $reimbursement->id }}">
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $reimbursement->id }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $reimbursement->user->nama_lengkap ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ Str::limit($reimbursement->deskripsi, 30) }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
      @if($reimbursement->status == 'approved') bg-gradient-to-tl from-green-600 to-lime-400
       @elseif($reimbursement->status == 'pending') bg-gradient-to-tl from-blue-600 to-indigo-500
      @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
      {{ strtoupper($reimbursement->status) }}
    </span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.reimbursements.show', $reimbursement) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
    <a href="{{ route('admin.reimbursements.edit', $reimbursement) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 text-white rounded-2xl">Edit</a>
    @if($reimbursement->status == 'pending')
      <form action="{{ route('admin.reimbursements.approve', $reimbursement) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 text-white rounded-2xl">Approve</button>
      </form>
      <form action="{{ route('admin.reimbursements.reject', $reimbursement) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Reject</button>
      </form>
    @endif
    <form action="{{ route('admin.reimbursements.destroy', $reimbursement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reimbursement?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-gray-600 to-slate-400 text-white rounded-2xl">Delete</button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="7" class="p-4 text-center text-slate-400">No reimbursement requests found</td>
</tr>
@endforelse
</tbody></table>
<div class="p-4">
{{ $reimbursements->links() }}
</div>
