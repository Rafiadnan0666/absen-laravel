@extends('admin.dashboard.layout')

@section('title', 'Payroll Records - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border" x-data="tableFilter({ search: '', filterStatus: '', filterUserId: '', periodeFrom: '', periodeTo: '' })" x-init="init()">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
          <h6 class="text-xl font-bold">Payroll Records</h6>
          <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
            <div class="relative flex-1 sm:flex-initial">
              <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input type="text" x-model="filters.search" @input.debounce.300ms="fetch()" placeholder="Search employee..." class="w-full sm:w-36 pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 focus:ring-1 focus:ring-purple-400 outline-none">
            </div>
            <select x-model="filters.filterUserId" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Employees</option>
              @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
              @endforeach
            </select>
            <select x-model="filters.filterStatus" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="paid">Paid</option>
            </select>
            <input type="month" x-model="filters.periodeFrom" @change="fetch()" placeholder="From" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-28">
            <input type="month" x-model="filters.periodeTo" @change="fetch()" placeholder="To" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-28">
            <a href="{{ route('admin.payrolls.create') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white whitespace-nowrap">
              <i class="fas fa-plus mr-1"></i> Add Payroll
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
        <div x-show="loading" class="filter-loading">
          <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
        </div>
        <div class="overflow-x-auto" data-table-container>
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">ID</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Period</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Base Salary</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Overtime</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Deductions</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Actions</th>
              </tr>
            </thead>
            <tbody>
              @include('admin.payrolls._table')
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
