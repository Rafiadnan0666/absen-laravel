@extends('admin.dashboard.layout')

@section('title', 'Edit Overtime Rule - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6">
      <h6 class="text-xl font-bold">Edit Overtime Rule</h6>
    </div>

    <form action="{{ route('admin.overtime-rules.update', $overtimeRule) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="minimal_jam" class="neo-label">Minimum Hours</label>
        <input type="number" step="0.01" id="minimal_jam" name="minimal_jam" value="{{ old('minimal_jam', $overtimeRule->minimal_jam) }}"
          class="neo-input" placeholder="Enter minimum hours" required>
        @error('minimal_jam')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="multiplier" class="neo-label">Multiplier</label>
        <input type="number" step="0.01" id="multiplier" name="multiplier" value="{{ old('multiplier', $overtimeRule->multiplier) }}"
          class="neo-input" placeholder="Enter multiplier (e.g. 1.5)" required>
        @error('multiplier')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('admin.overtime-rules.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
        <button type="submit" class="neo-btn-primary">
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection