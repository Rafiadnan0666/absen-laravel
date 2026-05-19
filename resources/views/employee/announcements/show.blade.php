@extends('layouts.employee')

@section('page-title', 'Announcement')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">Announcement</h1>
        <a href="{{ route('employee.announcements.index') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-slate-600 to-slate-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            Back
        </a>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <h2 class="text-3xl font-black mb-4 text-slate-700">{{ $announcement->judul }}</h2>
            <p class="text-sm text-slate-500 mb-6">
                Posted on {{ $announcement->created_at->format('d M Y H:i') }}
                by {{ $announcement->creator->nama_lengkap ?? 'Admin' }}
            </p>
            <div class="relative w-full px-5 py-4 mx-auto overflow-hidden bg-slate-50 border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border">
                <div class="text-slate-700 whitespace-pre-wrap">{!! \App\Helpers\TextHelper::renderLinks($announcement->isi) !!}</div>
            </div>
        </div>
    </div>
@endsection
