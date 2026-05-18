@extends('admin.dashboard.layout')

@section('title', 'Attendance Records - Admin')
@section('page-title', 'Attendance')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <!-- Stats Recap -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-4">
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Total</p>
        <p class="text-lg font-bold text-slate-700 mb-0">{{ $total }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-green-500">Present</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $totalPresent }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-orange-500">Late</p>
        <p class="text-lg font-bold text-orange-600 mb-0">{{ $totalLate }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-red-500">Absent</p>
        <p class="text-lg font-bold text-red-600 mb-0">{{ $totalAbsent }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Today Present</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $todayPresent }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Today Late</p>
        <p class="text-lg font-bold text-orange-600 mb-0">{{ $todayLate }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Today Absent</p>
        <p class="text-lg font-bold text-red-600 mb-0">{{ $todayAbsent }}</p>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border" x-data="tableFilter({ search: '', filterStatus: '', filterDept: '', dateFrom: '', dateTo: '' })" x-init="init()">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
          <h6 class="text-xl font-bold">Attendance Records</h6>
          <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
            <div class="relative flex-1 sm:flex-initial">
              <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input type="text" x-model="filters.search" @input.debounce.300ms="fetch()" placeholder="Search employee..." class="w-full sm:w-36 pl-8 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 focus:ring-1 focus:ring-purple-400 outline-none">
            </div>
            <input type="date" x-model="filters.dateFrom" @change="fetch()" placeholder="From" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
            <input type="date" x-model="filters.dateTo" @change="fetch()" placeholder="To" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
            <select x-model="filters.filterDept" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Departments</option>
              @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
              @endforeach
            </select>
            <select x-model="filters.filterStatus" @change="fetch()" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
              <option value="">All Status</option>
              <option value="present">Present</option>
              <option value="late">Late</option>
              <option value="absent">Absent</option>
            </select>
            <a href="{{ route('admin.attendances.create') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white whitespace-nowrap">
              <i class="fas fa-plus mr-1"></i> Add
            </a>
            <a href="{{ route('admin.attendances.export', request()->query()) }}" class="inline-block px-4 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 text-white whitespace-nowrap">
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
        <div x-show="loading" class="filter-loading">
          <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
        </div>
        <div class="overflow-x-auto" data-table-container>
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">ID</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Check In</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Check Out</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Work Hours</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Actions</th>
              </tr>
            </thead>
            <tbody>
              @include('admin.attendances._table')
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
