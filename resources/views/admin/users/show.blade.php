@extends('admin.dashboard.layout')

@section('title', 'Employee Details - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card border-3 border-black">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <a href="{{ route('admin.users.index') }}" class="neo-btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
          <h6 class="text-xl font-bold ml-4">{{ strtoupper($user->nama_lengkap) }}</h6>
        </div>
        <div class="flex space-x-2">
          <a href="{{ route('admin.users.edit', $user) }}" class="neo-btn-primary">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="neo-btn-danger">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="neo-card border-3 border-black">
        <div class="mb-4 border-b-3 border-black pb-4">
          <h6 class="mb-0 text-xl font-bold">Employee Info</h6>
        </div>
        <div class="space-y-4">
          <div>
            <label class="neo-label">ID</label>
            <p class="text-sm font-bold">{{ $user->id }}</p>
          </div>
          <div>
            <label class="neo-label">Full Name</label>
            <p class="text-sm">{{ $user->nama_lengkap }}</p>
          </div>
          <div>
            <label class="neo-label">Email</label>
            <p class="text-sm">{{ $user->email }}</p>
          </div>
          <div>
            <label class="neo-label">Phone</label>
            <p class="text-sm">{{ $user->no_hp ?? 'N/A' }}</p>
          </div>
          <div>
            <label class="neo-label">Address</label>
            <p class="text-sm">{{ $user->alamat ?? 'N/A' }}</p>
          </div>
          <div>
            <label class="neo-label">Department</label>
            <p class="text-sm">{{ $user->department->nama_department ?? 'N/A' }}</p>
          </div>
          <div>
            <label class="neo-label">Job Title</label>
            <p class="text-sm">{{ $user->jobTitle->nama_jabatan ?? 'N/A' }}</p>
          </div>
          <div>
            <label class="neo-label">Role</label>
            <span class="neo-badge neo-badge-purple">{{ $user->role->nama_role ?? 'N/A' }}</span>
          </div>
          <div>
            <label class="neo-label">Salary Type</label>
            <p class="text-sm">{{ strtoupper($user->tipe_gaji) }}</p>
          </div>
          <div>
            <label class="neo-label">Salary Amount</label>
            <p class="text-sm font-bold">Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}</p>
          </div>
          <div>
            <label class="neo-label">Join Date</label>
            <p class="text-sm">{{ $user->tanggal_masuk->format('d M Y') }}</p>
          </div>
          <div>
            <label class="neo-label">Status</label>
            @if($user->status_akun == 'active')
              <span class="neo-badge neo-badge-green">{{ strtoupper($user->status_akun) }}</span>
            @else
              <span class="neo-badge neo-badge-red">{{ strtoupper($user->status_akun) }}</span>
            @endif
          </div>
          <div>
            <label class="neo-label">Face Registered</label>
            @if($user->face_embedding)
              <span class="neo-badge neo-badge-green">YES</span>
            @else
              <span class="neo-badge neo-badge-red">NO</span>
            @endif
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="neo-card border-3 border-black">
          <div class="mb-4 border-b-3 border-black pb-4">
            <h6 class="mb-0 text-xl font-bold">Attendance Summary</h6>
          </div>
          <div class="space-y-4">
            <div>
              <label class="neo-label">Total Records</label>
              <p class="text-2xl font-bold">{{ $user->attendances->count() }}</p>
            </div>
            <div>
              <label class="neo-label">Present</label>
              <p class="text-2xl font-bold"><span class="neo-badge neo-badge-green">{{ $user->attendances->where('status_hadir', 'present')->count() }}</span></p>
            </div>
            <div>
              <label class="neo-label">Late</label>
              <p class="text-2xl font-bold"><span class="neo-badge neo-badge-yellow">{{ $user->attendances->where('status_hadir', 'late')->count() }}</span></p>
            </div>
            <div>
              <label class="neo-label">Absent</label>
              <p class="text-2xl font-bold"><span class="neo-badge neo-badge-red">{{ $user->attendances->where('status_hadir', 'absent')->count() }}</span></p>
            </div>
          </div>
        </div>

        <div class="neo-card border-3 border-black">
          <div class="mb-4 border-b-3 border-black pb-4">
            <h6 class="mb-0 text-xl font-bold">Leave History</h6>
          </div>
          <div class="neo-table-container overflow-x-auto">
            <table class="neo-table w-full">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Period</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($user->leaves as $leave)
                <tr>
                  <td>
                    <span class="neo-badge neo-badge-cyan">{{ ucfirst($leave->tipe_cuti) }}</span>
                  </td>
                  <td class="text-sm">
                    <p class="mb-0">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</p>
                  </td>
                  <td>
                    @if($leave->status_pengajuan == 'approved')
                      <span class="neo-badge neo-badge-green">{{ strtoupper($leave->status_pengajuan) }}</span>
                    @elseif($leave->status_pengajuan == 'pending')
                      <span class="neo-badge neo-badge-yellow">{{ strtoupper($leave->status_pengajuan) }}</span>
                    @else
                      <span class="neo-badge neo-badge-red">{{ strtoupper($leave->status_pengajuan) }}</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center p-4">No leave records</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="neo-card border-3 border-black">
          <div class="mb-4 border-b-3 border-black pb-4">
            <h6 class="mb-0 text-xl font-bold">Payroll History</h6>
          </div>
          <div class="neo-table-container overflow-x-auto">
            <table class="neo-table w-full">
              <thead>
                <tr>
                  <th>Period</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($user->payrolls as $payroll)
                <tr>
                  <td class="text-sm">
                    <p class="mb-0">{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</p>
                  </td>
                  <td class="font-bold">
                    <p class="mb-0">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</p>
                  </td>
                  <td>
                    @if($payroll->status_pembayaran == 'paid')
                      <span class="neo-badge neo-badge-green">{{ strtoupper($payroll->status_pembayaran) }}</span>
                    @else
                      <span class="neo-badge neo-badge-yellow">{{ strtoupper($payroll->status_pembayaran) }}</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center p-4">No payroll records</td>
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
@endsection