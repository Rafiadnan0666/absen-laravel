@extends('admin.dashboard.layout')

@section('title', 'View Overtime Rule - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6">
      <h6 class="text-xl font-bold">Overtime Rule Details</h6>
      <a href="{{ route('admin.overtime-rules.index') }}" class="neo-btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back
      </a>
    </div>

    <div class="mb-4">
      <label class="neo-label">ID</label>
      <p class="text-sm">{{ $overtimeRule->id }}</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">Minimum Hours</label>
      <p class="text-sm">{{ $overtimeRule->minimal_jam }} hours</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">Multiplier</label>
      <span class="neo-badge neo-badge-green">{{ $overtimeRule->multiplier }}x</span>
    </div>

    <div class="flex justify-end mt-6 gap-2">
      <a href="{{ route('admin.overtime-rules.edit', $overtimeRule) }}" class="neo-btn-secondary">
        <i class="fas fa-edit mr-1"></i> Edit
      </a>
      <form action="{{ route('admin.overtime-rules.destroy', $overtimeRule) }}" method="POST" class="inline" onsubmit="return confirm('Delete this overtime rule?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> Delete
        </button>
      </form>
    </div>
  </div>
</div>
@endsection