@extends('admin.dashboard.layout')

@section('title', 'Create Payroll - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card p-6">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">CREATE PAYROLL</h6>
    </div>

    @if($errors->any())
    <div class="neo-alert-danger mb-6 shake">
      <ul class="list-disc pl-4">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.payrolls.store') }}" method="POST"
        x-data="{ gaji: 0, lembur: 0, potongan: 0, bonusVal: 0 }">
      @csrf

      <div class="mb-4">
        <label class="neo-label" for="user_id">EMPLOYEE</label>
        <select id="user_id" name="user_id" required class="neo-input">
          <option value="">SELECT EMPLOYEE</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
          @endforeach
        </select>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="mb-4">
          <label class="neo-label" for="periode_mulai">START PERIOD</label>
          <input type="date" id="periode_mulai" name="periode_mulai" value="{{ old('periode_mulai') }}" required class="neo-input">
        </div>

        <div class="mb-4">
          <label class="neo-label" for="periode_selesai">END PERIOD</label>
          <input type="date" id="periode_selesai" name="periode_selesai" value="{{ old('periode_selesai') }}" required class="neo-input">
        </div>
      </div>

      <div class="mb-4">
        <label class="neo-label" for="gaji_pokok">BASE SALARY</label>
        <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" placeholder="0" required class="neo-input" x-model.number="gaji">
      </div>

      <div class="mb-4">
        <label class="neo-label" for="total_lembur">OVERTIME PAY</label>
        <input type="number" step="0.01" id="total_lembur" name="total_lembur" value="{{ old('total_lembur') }}" placeholder="0" class="neo-input" x-model.number="lembur">
      </div>

      <div class="mb-4">
        <label class="neo-label" for="total_potongan">DEDUCTIONS</label>
        <input type="number" step="0.01" id="total_potongan" name="total_potongan" value="{{ old('total_potongan') }}" placeholder="0" class="neo-input" x-model.number="potongan">
      </div>

      <div class="mb-4">
        <label class="neo-label" for="bonus">BONUS</label>
        <input type="number" step="0.01" id="bonus" name="bonus" value="{{ old('bonus') }}" placeholder="0" class="neo-input" x-model.number="bonusVal">
      </div>

      <div class="mb-4">
        <label class="neo-label" for="status_pembayaran">PAYMENT STATUS</label>
        <select id="status_pembayaran" name="status_pembayaran" required class="neo-input">
          <option value="">SELECT STATUS</option>
          <option value="pending" {{ old('status_pembayaran') == 'pending' ? 'selected' : '' }}>PENDING</option>
          <option value="paid" {{ old('status_pembayaran') == 'paid' ? 'selected' : '' }}>PAID</option>
        </select>
      </div>

      <div class="neo-card-yellow p-4 mb-4">
        <div class="flex justify-between items-center">
          <span class="font-black text-sm">TOTAL CALCULATION:</span>
          <span class="text-2xl font-black" x-text="'Rp ' + Math.max(0, (+gaji || 0) + (+lembur || 0) + (+bonusVal || 0) - (+potongan || 0)).toLocaleString('id-ID')">Rp 0</span>
        </div>
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('admin.payrolls.index') }}" class="neo-btn-secondary">CANCEL</a>
        <button type="submit" class="neo-btn-primary pulse-glow">CREATE PAYROLL</button>
      </div>
    </form>
  </div>
</div>
@endsection
