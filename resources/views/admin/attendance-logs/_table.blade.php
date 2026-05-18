@forelse($attendanceLogs as $log)
<tr>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $log->id }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $log->user->nama_lengkap ?? $log->user->name ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="bg-gradient-to-tl {{ $log->tipe_log == 'check_in' ? 'from-green-600 to-lime-400' : 'from-red-600 to-rose-400' }} px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">
      {{ ucfirst(str_replace('_', ' ', $log->tipe_log)) }}
    </span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $log->waktu_log->format('d M Y H:i') }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">
      @if($log->latitude && $log->longitude)
        {{ $log->latitude }}, {{ $log->longitude }}
      @else
        N/A
      @endif
    </p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $log->device ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.attendance-logs.show', $log) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
    <form action="{{ route('admin.attendance-logs.destroy', $log) }}" method="POST" class="inline" onsubmit="return confirm('Delete this log?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Delete</button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="7" class="p-4 text-center text-slate-400">No attendance logs found</td>
</tr>
@endforelse
</tbody></table>
<div class="p-4">
{{ $attendanceLogs->links() }}
</div>
