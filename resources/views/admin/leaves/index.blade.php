@extends('admin.dashboard.layout')

@section('title', 'Leave Requests - Admin')
@section('page-title', 'Leaves')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <!-- Stats Recap -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Total</p>
        <p class="text-lg font-bold text-slate-700 mb-0">{{ $totalLeaves }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-amber-500">Pending</p>
        <p class="text-lg font-bold text-amber-600 mb-0">{{ $pendingCount }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-green-500">Approved</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $approvedCount }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-red-500">Rejected</p>
        <p class="text-lg font-bold text-red-600 mb-0">{{ $rejectedCount }}</p>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border" x-data="tableFilter({ search: '', filterStatus: '', filterType: '', dateFrom: '', dateTo: '' })" x-init="init()">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
          <h6 class="text-xl font-bold">Leave Requests</h6>
          <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
            <div class="relative flex-1 sm:flex-initial">
              <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input type="text" x-model="filters.search" @input.debounce.300ms="fetch()" placeholder="Search employee..." class="w-full sm:w-36 pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 focus:ring-1 focus:ring-purple-400 outline-none">
            </div>
            <input type="date" x-model="filters.dateFrom" @change="fetch()" placeholder="From" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
            <input type="date" x-model="filters.dateTo" @change="fetch()" placeholder="To" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
            <select x-model="filters.filterType" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Types</option>
              <option value="sick">Sick</option>
              <option value="annual">Annual</option>
              <option value="unpaid">Unpaid</option>
            </select>
            <select x-model="filters.filterStatus" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
            <a href="{{ route('admin.leaves.create') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white whitespace-nowrap">
              <i class="fas fa-plus mr-1"></i> Add
            </a>
            <a href="{{ route('admin.leaves.export', request()->query()) }}" class="inline-block px-4 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 text-white whitespace-nowrap">
              <i class="fas fa-download mr-1"></i> CSV
            </a>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2 relative">
        @if(session('success'))
          <div class="p-4 mb-4 mx-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="p-4 mb-4 mx-6 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            {{ session('error') }}
          </div>
        @endif
        <div x-show="loading" class="filter-loading">
          <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
        </div>
        <div class="overflow-x-auto" data-table-container>
          <form id="bulk-form" action="" method="POST">
            @csrf
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
              <thead class="align-bottom">
                <tr>
                  <th class="px-2 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    <input type="checkbox" id="select-all" class="rounded border-slate-300 text-purple-600 focus:ring-purple-500">
                  </th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">ID</th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Type</th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Period</th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Reason</th>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                  <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Actions</th>
                </tr>
              </thead>
              <tbody>
                @include('admin.leaves._table')
              </tbody>
            </table>
          </form>
        </div>
        <div class="flex items-center gap-2 px-4 pt-2" id="bulk-actions" style="display: none;">
          <span class="text-xs text-slate-500" id="selected-count">0 selected</span>
          <button type="button" onclick="document.getElementById('bulk-form').action='{{ route('admin.leaves.bulkApprove') }}'; document.getElementById('bulk-form').submit();" class="px-3 py-1 text-xs font-bold uppercase text-white rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">Approve Selected</button>
          <button type="button" onclick="document.getElementById('bulk-form').action='{{ route('admin.leaves.bulkReject') }}'; document.getElementById('bulk-form').submit();" class="px-3 py-1 text-xs font-bold uppercase text-white rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">Reject Selected</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const selectAll = document.getElementById('select-all');
  const checkboxes = document.querySelectorAll('.bulk-checkbox');
  const bulkActions = document.getElementById('bulk-actions');
  const selectedCount = document.getElementById('selected-count');

  selectAll?.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkUI();
  });

  checkboxes.forEach(cb => {
    cb.addEventListener('change', updateBulkUI);
  });

  function updateBulkUI() {
    const checked = document.querySelectorAll('.bulk-checkbox:checked');
    const count = checked.length;
    selectedCount.textContent = count + ' selected';

    if (count > 0) {
      const ids = Array.from(checked).map(cb => cb.value).join(',');
      document.getElementById('bulk-form').querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
      checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        document.getElementById('bulk-form').appendChild(input);
      });
      bulkActions.style.display = 'flex';
    } else {
      bulkActions.style.display = 'none';
    }
  }
});
</script>
@endsection
