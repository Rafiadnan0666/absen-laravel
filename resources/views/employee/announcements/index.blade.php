@extends('layouts.employee')

@section('page-title', 'Announcements')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">Announcements</h1>

    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-black text-slate-700">{{ $announcement->judul }}</h3>
                        <span class="text-sm text-slate-500">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="relative w-full px-5 py-4 mx-auto overflow-hidden bg-slate-50 border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border mb-4">
                        <div class="text-slate-700 whitespace-pre-wrap">{!! \App\Helpers\TextHelper::renderLinks(\Illuminate\Support\Str::limit($announcement->isi, 300)) !!}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-slate-500">By: {{ $announcement->creator->nama_lengkap ?? 'Admin' }}</p>
                        <a href="{{ route('employee.announcements.show', $announcement) }}" class="inline-block px-4 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <p class="font-bold text-slate-400 py-4 text-center">No announcements yet</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
@endsection
