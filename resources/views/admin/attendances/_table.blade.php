@forelse($attendances as $attendance)
<tr>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $attendance->id }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $attendance->check_in ?? '-' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $attendance->check_out ?? '-' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
      @if($attendance->status_hadir == 'present') bg-gradient-to-tl from-green-600 to-lime-400
       @elseif($attendance->status_hadir == 'late') bg-gradient-to-tl from-red-600 to-orange-400
      @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
      {{ strtoupper($attendance->status_hadir) }}
    </span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '-' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.attendances.show', $attendance) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
    <a href="{{ route('admin.attendances.edit', $attendance) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 text-white rounded-2xl">Edit</a>
    <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Delete</button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="8" class="p-4 text-center text-slate-400">No attendance records found</td>
</tr>
@endforelse
</tbody></table>
<div class="p-4">
{{ $attendances->links() }}
</div>
