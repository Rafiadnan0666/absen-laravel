@extends('admin.dashboard.layout')

@section('title', 'View Salary Rule - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">Salary Rule Details</h6>
        <a href="{{ route('admin.salary-rules.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>
    <div class="space-y-4">
      <div>
        <label class="neo-label">ID</label>
        <p class="text-sm font-bold">{{ $salaryRule->id }}</p>
      </div>
      <div>
        <label class="neo-label">Salary Type</label>
        <span class="neo-badge">{{ ucfirst($salaryRule->tipe_gaji) }}</span>
      </div>
      <div>
        <label class="neo-label">Overtime Rate</label>
        <p class="text-sm font-bold">{{ $salaryRule->rate_lembur }}</p>
      </div>
      <div>
        <label class="neo-label">Late Penalty per Minute</label>
        <p class="text-sm font-bold">{{ $salaryRule->penalti_telat_per_menit }}</p>
      </div>
      <div>
        <label class="neo-label">Absent Penalty</label>
        <p class="text-sm font-bold">{{ $salaryRule->penalti_tidak_hadir }}</p>
      </div>
      <div class="flex gap-4 mt-6">
        <a href="{{ route('admin.salary-rules.edit', $salaryRule) }}" class="neo-btn-primary">
          <i class="fas fa-edit mr-1"></i> Edit
        </a>
        <form action="{{ route('admin.salary-rules.destroy', $salaryRule) }}" method="POST" class="inline" onsubmit="return confirm('Delete this salary rule?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="neo-btn-danger">
            <i class="fas fa-trash mr-1"></i> Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection