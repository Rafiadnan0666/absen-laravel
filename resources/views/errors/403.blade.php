@extends('layouts.app')

@section('title', 'Access Forbidden - ABS')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
            <div class="p-8 text-center">
                <div class="flex items-center justify-center mb-6">
                     <div class="bg-gradient-to-tl from-blue-600 to-indigo-500 text-white rounded-full p-4">
                        <i class="fas fa-lock text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 mb-4">403</h1>
                <p class="text-xl font-semibold text-slate-700 mb-6">Access Forbidden</p>
                <p class="text-slate-600 mb-8">
                    You don't have permission to access this resource.
                    Please contact your administrator if you believe this is a mistake.
                </p>
                <div class="space-x-4">
                    <a href="{{ url('/') }}" class="inline-block px-6 py-3 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">
                        <i class="fas fa-home mr-2"></i> Go to Homepage
                    </a>
                    <a href="javascript:history.back()" class="inline-block px-6 py-3 text-xs font-bold text-slate-700 uppercase rounded-lg border border-solid border-slate-300 hover:bg-slate-50 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i> Go Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection