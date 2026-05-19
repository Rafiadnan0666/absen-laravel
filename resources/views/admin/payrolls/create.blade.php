@extends('admin.dashboard.layout')

@section('title', 'Create Payroll - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Create Payroll</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.payrolls.store') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label for="user_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
            <select id="user_id" name="user_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Employee</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
              @endforeach
            </select>
            @error('user_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="periode_mulai" class="inline-block mb-2 text-sm font-bold text-slate-700">Start Period</label>
            <input type="date" id="periode_mulai" name="periode_mulai" value="{{ old('periode_mulai') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              required>
            @error('periode_mulai')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="periode_selesai" class="inline-block mb-2 text-sm font-bold text-slate-700">End Period</label>
            <input type="date" id="periode_selesai" name="periode_selesai" value="{{ old('periode_selesai') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              required>
            @error('periode_selesai')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="gaji_pokok" class="inline-block mb-2 text-sm font-bold text-slate-700">Base Salary</label>
            <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter base salary" required>
            @error('gaji_pokok')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="total_lembur" class="inline-block mb-2 text-sm font-bold text-slate-700">Overtime Pay</label>
            <input type="number" step="0.01" id="total_lembur" name="total_lembur" value="{{ old('total_lembur') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter overtime pay">
            @error('total_lembur')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="total_potongan" class="inline-block mb-2 text-sm font-bold text-slate-700">Deductions</label>
            <input type="number" step="0.01" id="total_potongan" name="total_potongan" value="{{ old('total_potongan') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter deductions">
            @error('total_potongan')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="bonus" class="inline-block mb-2 text-sm font-bold text-slate-700">Bonus</label>
            <input type="number" step="0.01" id="bonus" name="bonus" value="{{ old('bonus') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter bonus">
            @error('bonus')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="total_gaji_display" class="inline-block mb-2 text-sm font-bold text-slate-700">Total Salary</label>
            <input type="text" id="total_gaji_display"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500"
              readonly placeholder="Auto-calculated">
            <input type="hidden" id="total_gaji" name="total_gaji" value="0">
            <p class="text-xs text-slate-400 mt-1">Auto-calculated: Base Salary + Overtime + Bonus - Deductions</p>
          </div>
          <div class="mb-4">
            <label for="status_pembayaran" class="inline-block mb-2 text-sm font-bold text-slate-700">Payment Status</label>
            <select id="status_pembayaran" name="status_pembayaran" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Status</option>
              <option value="pending" {{ old('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ old('status_pembayaran') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
            @error('status_pembayaran')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-between items-center">
            <button type="button" id="btn-auto-calc"
              class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 text-white">
              <i class="fas fa-calculator mr-1"></i> Auto Calculate from Attendance
            </button>
            <div>
              <a href="{{ route('admin.payrolls.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
                Cancel
              </a>
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                Create
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userId = document.getElementById('user_id');
    const gajiPokok = document.getElementById('gaji_pokok');
    const totalLembur = document.getElementById('total_lembur');
    const totalPotongan = document.getElementById('total_potongan');
    const bonus = document.getElementById('bonus');
    const totalGajiHidden = document.getElementById('total_gaji');
    const totalGajiDisplay = document.getElementById('total_gaji_display');
    const periodeMulai = document.getElementById('periode_mulai');
    const periodeSelesai = document.getElementById('periode_selesai');
    const btnAutoCalc = document.getElementById('btn-auto-calc');

    function calcTotal() {
        const pokok = parseFloat(gajiPokok.value) || 0;
        const lembur = parseFloat(totalLembur.value) || 0;
        const potongan = parseFloat(totalPotongan.value) || 0;
        const bns = parseFloat(bonus.value) || 0;
        const total = pokok + lembur + bns - potongan;
        totalGajiHidden.value = total.toFixed(2);
        totalGajiDisplay.value = total.toFixed(2);
    }

    [gajiPokok, totalLembur, totalPotongan, bonus].forEach(el => {
        el.addEventListener('input', calcTotal);
    });

    userId.addEventListener('change', function () {
        if (this.value) {
            fetch(`{{ route('admin.payrolls.calculate') }}?user_id=${this.value}&periode_mulai=${periodeMulai.value}&periode_selesai=${periodeSelesai.value}`)
                .then(r => r.json())
                .then(data => {
                    gajiPokok.value = data.gaji_pokok;
                    calcTotal();
                })
                .catch(() => {});
        }
    });

    btnAutoCalc.addEventListener('click', function () {
        if (!userId.value || !periodeMulai.value || !periodeSelesai.value) {
            alert('Please select employee and period first.');
            return;
        }
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Calculating...';
        fetch(`{{ route('admin.payrolls.calculate') }}?user_id=${userId.value}&periode_mulai=${periodeMulai.value}&periode_selesai=${periodeSelesai.value}`)
            .then(r => r.json())
            .then(data => {
                gajiPokok.value = data.gaji_pokok;
                totalLembur.value = data.total_lembur;
                totalPotongan.value = data.total_potongan;
                calcTotal();
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-calculator mr-1"></i> Auto Calculate from Attendance';
            })
            .catch(() => {
                alert('Error calculating. Please try again.');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-calculator mr-1"></i> Auto Calculate from Attendance';
            });
    });

    if (periodeMulai.value && periodeSelesai.value && userId.value) {
        userId.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
