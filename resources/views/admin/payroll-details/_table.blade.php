@foreach($payrollDetails as $detail)
<tr>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs">{{ $detail->id }}</p>
  </td>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs">{{ $detail->payroll->user->nama_lengkap ?? 'N/A' }} ({{ $detail->payroll->periode_mulai->format('M Y') }})</p>
  </td>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
      @if($detail->tipe == 'base') bg-gradient-to-tl from-blue-600 to-indigo-500
      @elseif($detail->tipe == 'overtime') bg-gradient-to-tl from-green-600 to-lime-400
      @elseif($detail->tipe == 'penalty') bg-gradient-to-tl from-red-600 to-rose-400
      @else bg-gradient-to-tl from-purple-600 to-pink-500 @endif">
      {{ ucfirst($detail->tipe) }}
    </span>
  </td>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs">{{ $detail->deskripsi ?? '-' }}</p>
  </td>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs font-semibold">{{ $detail->tipe == 'penalty' ? '-' : '+' }}Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</p>
  </td>
  <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.payroll-details.edit', $detail) }}" class="text-blue-500 hover:text-blue-600 text-xs font-semibold mr-3" title="Edit"><i class="fas fa-edit"></i></a>
    <form action="{{ route('admin.payroll-details.destroy', $detail) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll detail?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-red-500 hover:text-red-600 text-xs font-semibold" title="Delete"><i class="fas fa-trash"></i></button>
    </form>
  </td>
</tr>
@endforeach