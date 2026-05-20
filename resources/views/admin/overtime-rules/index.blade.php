@extends('admin.dashboard.layout')

@section('title', 'Overtime Rules - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">OVERTIME RULES</h6>
      <a href="{{ route('admin.overtime-rules.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Overtime Rule
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="neo-table-container overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Min Hours</th>
            <th>Multiplier</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($overtimeRules as $rule)
          <tr>
            <td>{{ $rule->id }}</td>
            <td>{{ $rule->minimal_jam }} hours</td>
            <td>
              <span class="neo-badge neo-badge-green">{{ $rule->multiplier }}x</span>
            </td>
            <td class="text-center">
              <a href="{{ route('admin.overtime-rules.show', $rule) }}" class="neo-btn-secondary">View</a>
              <a href="{{ route('admin.overtime-rules.edit', $rule) }}" class="neo-btn-secondary">Edit</a>
              <form action="{{ route('admin.overtime-rules.destroy', $rule) }}" method="POST" class="inline" onsubmit="return confirm('Delete this rule?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center p-4">No overtime rules found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-4">
      {{ $overtimeRules->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection