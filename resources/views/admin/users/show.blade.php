@extends('admin.dashboard.layout')

@section('title', 'Employee Details - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <div class="flex items-center">
            <a href="{{ route('admin.users.index') }}" class="inline-block px-6 py-3 mb-0 mr-4 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
            <h6 class="text-xl font-bold">{{ strtoupper($user->nama_lengkap) }}</h6>
          </div>
          <div class="flex space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white">
              <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 text-white">
                <i class="fas fa-trash mr-1"></i> Delete
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3 xl:w-1/2">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-xl font-bold">Employee Info</h6>
              </div>
              <div class="flex-auto p-6">
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
                  <p class="text-sm text-slate-500">{{ $user->id }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Full Name</label>
                  <p class="text-sm text-slate-500">{{ $user->nama_lengkap }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Email</label>
                  <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Phone</label>
                  <p class="text-sm text-slate-500">{{ $user->no_hp ?? 'N/A' }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Address</label>
                  <p class="text-sm text-slate-500">{{ $user->alamat ?? 'N/A' }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Department</label>
                  <p class="text-sm text-slate-500">{{ $user->department->nama_department ?? 'N/A' }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Job Title</label>
                  <p class="text-sm text-slate-500">{{ $user->jobTitle->nama_jabatan ?? 'N/A' }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Role</label>
                  <span class="bg-gradient-to-tl from-purple-700 to-pink-500 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ $user->role->nama_role ?? 'N/A' }}</span>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Type</label>
                  <p class="text-sm text-slate-500">{{ strtoupper($user->tipe_gaji) }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Amount</label>
                  <p class="text-sm font-bold text-slate-700">Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Join Date</label>
                  <p class="text-sm text-slate-500">{{ $user->tanggal_masuk->format('d M Y') }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                    @if($user->status_akun == 'active') bg-gradient-to-tl from-green-600 to-lime-400
                    @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                    {{ strtoupper($user->status_akun) }}
                  </span>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Face Registered</label>
                  @if($user->face_embedding)
                    <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">YES</span>
                  @else
                    <span class="bg-gradient-to-tl from-red-600 to-rose-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">NO</span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="w-full max-w-full px-3 xl:w-1/2">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-xl font-bold">Attendance Summary</h6>
              </div>
              <div class="flex-auto p-6">
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Total Records</label>
                  <p class="text-2xl font-bold text-slate-700">{{ $user->attendances->count() }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Present</label>
                  <p class="text-2xl font-bold text-green-600">{{ $user->attendances->where('status_hadir', 'present')->count() }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Late</label>
                   <p class="text-2xl font-bold text-gray-600">{{ $user->attendances->where('status_hadir', 'late')->count() }}</p>
                </div>
                <div class="mb-4">
                  <label class="inline-block mb-2 text-sm font-bold text-slate-700">Absent</label>
                  <p class="text-2xl font-bold text-red-600">{{ $user->attendances->where('status_hadir', 'absent')->count() }}</p>
                </div>
              </div>
            </div>

            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-xl font-bold">Leave History</h6>
              </div>
              <div class="flex-auto p-6 px-0 pt-0 pb-2">
                <div class="overflow-x-auto">
                  <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                      <tr>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Type</th>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Period</th>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($user->leaves as $leave)
                      <tr>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ ucfirst($leave->tipe_cuti) }}</span>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <p class="mb-0 leading-normal text-xs text-slate-400">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</p>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                            @if($leave->status_pengajuan == 'approved') bg-gradient-to-tl from-green-600 to-lime-400
                             @elseif($leave->status_pengajuan == 'pending') bg-gradient-to-tl from-blue-600 to-indigo-500
                            @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                            {{ strtoupper($leave->status_pengajuan) }}
                          </span>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="3" class="p-4 text-center text-slate-400">No leave records</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-xl font-bold">Payroll History</h6>
              </div>
              <div class="flex-auto p-6 px-0 pt-0 pb-2">
                <div class="overflow-x-auto">
                  <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                      <tr>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Period</th>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Total</th>
                        <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($user->payrolls as $payroll)
                      <tr>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <p class="mb-0 leading-normal text-xs text-slate-400">{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</p>
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
                      </tr>
                      @empty
                      <tr>
                        <td colspan="3" class="p-4 text-center text-slate-400">No payroll records</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
