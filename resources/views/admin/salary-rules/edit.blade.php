@extends('admin.dashboard.layout')

@section('title', 'Edit Salary Rule - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">EDIT SALARY RULE</h6>
    </div>
    <form action="{{ route('admin.salary-rules.update', $salaryRule) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="tipe_gaji" class="neo-label">Salary Type</label>
        <select id="tipe_gaji" name="tipe_gaji" required class="neo-select">
          <option value="">Select Type</option>
          <option value="hourly" {{ old('tipe_gaji', $salaryRule->tipe_gaji) == 'hourly' ? 'selected' : '' }}>Hourly</option>
          <option value="daily" {{ old('tipe_gaji', $salaryRule->tipe_gaji) == 'daily' ? 'selected' : '' }}>Daily</option>
          <option value="monthly" {{ old('tipe_gaji', $salaryRule->tipe_gaji) == 'monthly' ? 'selected' : '' }}>Monthly</option>
        </select>
        @error('tipe_gaji')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="rate_lembur" class="neo-label">Overtime Rate</label>
        <input type="number" step="0.01" id="rate_lembur" name="rate_lembur" value="{{ old('rate_lembur', $salaryRule->rate_lembur) }}"
          class="neo-input" placeholder="Enter overtime rate" required>
        @error('rate_lembur')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="penalti_telat_per_menit" class="neo-label">Late Penalty per Minute</label>
        <input type="number" step="0.01" id="penalti_telat_per_menit" name="penalti_telat_per_menit" value="{{ old('penalti_telat_per_menit', $salaryRule->penalti_telat_per_menit) }}"
          class="neo-input" placeholder="Enter late penalty per minute" required>
        @error('penalti_telat_per_menit')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="penalti_tidak_hadir" class="neo-label">Absent Penalty</label>
        <input type="number" step="0.01" id="penalti_tidak_hadir" name="penalti_tidak_hadir" value="{{ old('penalti_tidak_hadir', $salaryRule->penalti_tidak_hadir) }}"
          class="neo-input" placeholder="Enter absent penalty" required>
        @error('penalti_tidak_hadir')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex gap-4">
        <button type="submit" class="neo-btn-primary">
          Update
        </button>
        <a href="{{ route('admin.salary-rules.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection