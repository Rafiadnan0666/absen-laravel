@extends('admin.dashboard.layout')

@section('title', 'Settings - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3">
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

    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">System Settings</h6>
      </div>
      
      <div class="flex-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- General Settings -->
          <div class="bg-gray-50 rounded-xl p-6">
            <h6 class="text-lg font-bold text-slate-700 mb-4">
              <i class="fas fa-cog mr-2 text-purple-600"></i>General Settings
            </h6>
            
            <form action="{{ route('admin.settings.general') }}" method="POST">
              @csrf
              <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 mb-1">Application Name</label>
                <input type="text" name="app_name" value="{{ $settings['app_name'] }}" 
                  class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              </div>

              <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 mb-1">Timezone</label>
                <select name="app_timezone" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                  <option value="Asia/Jakarta" {{ config('app.timezone') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (GMT+7)</option>
                  <option value="Asia/Makassar" {{ config('app.timezone') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (GMT+8)</option>
                  <option value="Asia/Jayapura" {{ config('app.timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (GMT+9)</option>
                  <option value="UTC" {{ config('app.timezone') == 'UTC' ? 'selected' : '' }}>UTC</option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 mb-1">App Mode</label>
                <select name="app_mode" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                  <option value="production" {{ config('app.env') == 'production' ? 'selected' : '' }}>Production</option>
                  <option value="local" {{ config('app.env') == 'local' ? 'selected' : '' }}>Development</option>
                </select>
              </div>

              <button type="submit" class="px-4 py-2 text-xs font-bold text-white uppercase bg-gradient-to-tl from-purple-700 to-pink-500 rounded-lg hover:scale-102 transition-all">
                Save Changes
              </button>
            </form>
          </div>

          <!-- System Info -->
          <div class="bg-gray-50 rounded-xl p-6">
            <h6 class="text-lg font-bold text-slate-700 mb-4">
              <i class="fas fa-info-circle mr-2 text-blue-600"></i>System Information
            </h6>
            
            <div class="space-y-3 text-sm">
              <div class="flex justify-between">
                <span class="text-slate-500">App Name</span>
                <span class="font-bold text-slate-700">{{ $settings['app_name'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">App URL</span>
                <span class="font-bold text-slate-700">{{ $settings['app_url'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Environment</span>
                <span class="font-bold text-slate-700">{{ $settings['app_env'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Debug Mode</span>
                <span class="font-bold text-slate-700">{{ $settings['app_debug'] ? 'Enabled' : 'Disabled' }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Timezone</span>
                <span class="font-bold text-slate-700">{{ $settings['timezone'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Database</span>
                <span class="font-bold text-slate-700">{{ $settings['db_database'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">PHP Version</span>
                <span class="font-bold text-slate-700">{{ $settings['php_version'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Laravel Version</span>
                <span class="font-bold text-slate-700">{{ $settings['laravel_version'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Storage Used</span>
                <span class="font-bold text-slate-700">{{ $settings['storage_used'] }} MB</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Cache Driver</span>
                <span class="font-bold text-slate-700">{{ $settings['cache_driver'] }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Session Driver</span>
                <span class="font-bold text-slate-700">{{ $settings['session_driver'] }}</span>
              </div>
            </div>
          </div>

          <!-- Cache Management -->
          <div class="bg-gray-50 rounded-xl p-6">
             <h6 class="text-lg font-bold text-slate-700 mb-4">
               <i class="fas fa-broom mr-2 text-gray-600"></i>Cache Management
            </h6>
            
            <p class="text-sm text-slate-500 mb-4">Clear system cache to refresh configuration and cached data.</p>
            
            <form action="{{ route('admin.settings.clearCache') }}" method="POST">
              @csrf
               <button type="submit" class="px-4 py-2 text-xs font-bold text-white uppercase bg-gradient-to-tl from-blue-600 to-indigo-500 rounded-lg hover:scale-102 transition-all">
                <i class="fas fa-trash mr-2"></i>Clear All Cache
              </button>
            </form>
          </div>

          <!-- Quick Links -->
          <div class="bg-gray-50 rounded-xl p-6">
            <h6 class="text-lg font-bold text-slate-700 mb-4">
              <i class="fas fa-link mr-2 text-green-600"></i>Quick Links
            </h6>
            
            <div class="space-y-2">
              <a href="{{ route('admin.departments.index') }}" class="block text-sm text-purple-600 hover:text-purple-700">
                <i class="fas fa-building mr-2"></i>Manage Departments
              </a>
              <a href="{{ route('admin.shifts.index') }}" class="block text-sm text-purple-600 hover:text-purple-700">
                <i class="fas fa-clock mr-2"></i>Manage Shifts
              </a>
              <a href="{{ route('admin.locations.index') }}" class="block text-sm text-purple-600 hover:text-purple-700">
                <i class="fas fa-map-marker-alt mr-2"></i>Manage Locations
              </a>
              <a href="{{ route('admin.roles.index') }}" class="block text-sm text-purple-600 hover:text-purple-700">
                <i class="fas fa-user-tag mr-2"></i>Manage Roles
              </a>
              <a href="{{ route('admin.announcements.index') }}" class="block text-sm text-purple-600 hover:text-purple-700">
                <i class="fas fa-bullhorn mr-2"></i>Announcements
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection