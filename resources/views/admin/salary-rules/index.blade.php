@extends('admin.dashboard.layout')

@section('title', 'Salary Rules - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h2 class="neo-section-title">SALARY RULES</h2>
      <a href="{{ route('admin.salary-rules.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Salary Rule
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="neo-table-container">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Overtime Rate</th>
            <th>Late Penalty/Min</th>
            <th>Absent Penalty</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($salaryRules as $rule)
          <tr>
            <td>{{ $rule->id }}</td>
            <td>
              <span class="neo-badge">{{ ucfirst($rule->tipe_gaji) }}</span>
            </td>
            <td>{{ $rule->rate_lembur }}</td>
            <td>{{ $rule->penalti_telat_per_menit }}</td>
            <td>{{ $rule->penalti_tidak_hadir }}</td>
            <td class="text-center">
              <a href="{{ route('admin.salary-rules.show', $rule) }}" class="neo-btn-secondary inline-block">View</a>
              <a href="{{ route('admin.salary-rules.edit', $rule) }}" class="neo-btn-secondary inline-block">Edit</a>
              <form action="{{ route('admin.salary-rules.destroy', $rule) }}" method="POST" class="inline" onsubmit="return confirm('Delete this rule?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-4">No salary rules found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $salaryRules->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection