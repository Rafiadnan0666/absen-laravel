@extends('admin.dashboard.layout')

@section('title', 'View Face Log - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">Face Log Details</h6>
        <a href="{{ route('admin.face-logs.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>
    <div>
      <div class="mb-4">
        <label class="neo-label">ID</label>
        <p class="text-sm">{{ $faceLog->id }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">User</label>
        <p class="text-sm">{{ $faceLog->user->name ?? 'N/A' }} ({{ $faceLog->user->email ?? 'N/A' }})</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Photo</label>
        @if($faceLog->foto_path)
          <img src="{{ asset('storage/' . $faceLog->foto_path) }}" alt="Face Photo" class="max-w-sm border-3 border-black shadow-neo">
        @else
          <p class="text-sm">No photo available</p>
        @endif
      </div>
      <div class="mb-4">
        <label class="neo-label">Confidence Score</label>
        <p class="text-sm">{{ $faceLog->confidence_score }}%</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Is Match</label>
        @if($faceLog->is_match)
          <span class="neo-badge neo-badge-green">Yes</span>
        @else
          <span class="neo-badge neo-badge-red">No</span>
        @endif
      </div>
      <div class="mb-4">
        <label class="neo-label">Created At</label>
        <p class="text-sm">{{ $faceLog->created_at->format('d M Y H:i:s') }}</p>
      </div>
      <div class="flex justify-end mt-6">
        <form action="{{ route('admin.face-logs.destroy', $faceLog) }}" method="POST" class="inline" onsubmit="return confirm('Delete this face log?')">
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
