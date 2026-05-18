@forelse($users as $user)
<tr>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->id }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 font-semibold leading-normal text-sm">{{ $user->nama_lengkap }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $user->email }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <p class="mb-0 leading-normal text-xs text-slate-400">{{ $user->department->nama_department ?? 'N/A' }}</p>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="bg-gradient-to-tl from-purple-700 to-pink-500 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ $user->role->nama_role ?? 'N/A' }}</span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
    <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
      @if($user->status_akun == 'active') bg-gradient-to-tl from-green-600 to-lime-400
      @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
      {{ strtoupper($user->status_akun) }}
    </span>
  </td>
  <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
    <a href="{{ route('admin.users.show', $user) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
    <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 text-white rounded-2xl">Edit</a>
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Delete</button>
    </form>
  </td>
</tr>
@empty
<tr>
  <td colspan="7" class="p-4 text-center text-slate-400">No employees found</td>
</tr>
@endforelse
</tbody></table>
<div class="p-4">
{{ $users->links() }}
</div>
