@extends('admin.dashboard.layout')

@section('title', 'Settings - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    @if(session('success'))
    <div class="neo-alert-success mb-4">
      {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="neo-alert-danger mb-4">
      {{ session('error') }}
    </div>
    @endif

    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">System Settings</h6>
    </div>
    
    <div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div class="neo-card-yellow">
          <h6 class="text-lg font-bold mb-4">
            <i class="fas fa-cog mr-2"></i>General Settings
          </h6>
          
          <form action="{{ route('admin.settings.general') }}" method="POST">
            @csrf
            <div class="mb-4">
              <label class="neo-label">Application Name</label>
              <input type="text" name="app_name" value="{{ $settings['app_name'] }}" 
                class="neo-input">
            </div>

            <div class="mb-4">
              <label class="neo-label">Timezone</label>
              <select name="app_timezone" class="neo-select">
                <option value="Asia/Jakarta" {{ config('app.timezone') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (GMT+7)</option>
                <option value="Asia/Makassar" {{ config('app.timezone') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (GMT+8)</option>
                <option value="Asia/Jayapura" {{ config('app.timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (GMT+9)</option>
                <option value="UTC" {{ config('app.timezone') == 'UTC' ? 'selected' : '' }}>UTC</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="neo-label">App Mode</label>
              <select name="app_mode" class="neo-select">
                <option value="production" {{ config('app.env') == 'production' ? 'selected' : '' }}>Production</option>
                <option value="local" {{ config('app.env') == 'local' ? 'selected' : '' }}>Development</option>
              </select>
            </div>

            <button type="submit" class="neo-btn-purple">
              Save Changes
            </button>
          </form>
        </div>

        <!-- System Info -->
        <div class="neo-card">
          <h6 class="text-lg font-bold mb-4">
            <i class="fas fa-info-circle mr-2"></i>System Information
          </h6>
          
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span>App Name</span>
              <span class="font-bold">{{ $settings['app_name'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>App URL</span>
              <span class="font-bold">{{ $settings['app_url'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Environment</span>
              <span class="font-bold">{{ $settings['app_env'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Debug Mode</span>
              <span class="font-bold">{{ $settings['app_debug'] ? 'Enabled' : 'Disabled' }}</span>
            </div>
            <div class="flex justify-between">
              <span>Timezone</span>
              <span class="font-bold">{{ $settings['timezone'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Database</span>
              <span class="font-bold">{{ $settings['db_database'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>PHP Version</span>
              <span class="font-bold">{{ $settings['php_version'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Laravel Version</span>
              <span class="font-bold">{{ $settings['laravel_version'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Storage Used</span>
              <span class="font-bold">{{ $settings['storage_used'] }} MB</span>
            </div>
            <div class="flex justify-between">
              <span>Cache Driver</span>
              <span class="font-bold">{{ $settings['cache_driver'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Session Driver</span>
              <span class="font-bold">{{ $settings['session_driver'] }}</span>
            </div>
          </div>
        </div>

        <!-- Cache Management -->
        <div class="neo-card-yellow">
          <h6 class="text-lg font-bold mb-4">
            <i class="fas fa-broom mr-2"></i>Cache Management
          </h6>
          
          <p class="text-sm mb-4">Clear system cache to refresh configuration and cached data.</p>
          
          <form action="{{ route('admin.settings.clearCache') }}" method="POST">
            @csrf
            <button type="submit" class="neo-btn-orange">
              <i class="fas fa-trash mr-2"></i>Clear All Cache
            </button>
          </form>
        </div>

        <!-- Quick Links -->
        <div class="neo-card-green">
          <h6 class="text-lg font-bold mb-4">
            <i class="fas fa-link mr-2"></i>Quick Links
          </h6>
          
          <div class="space-y-2">
            <a href="{{ route('admin.departments.index') }}" class="block text-sm hover:underline">
              <i class="fas fa-building mr-2"></i>Manage Departments
            </a>
            <a href="{{ route('admin.shifts.index') }}" class="block text-sm hover:underline">
              <i class="fas fa-clock mr-2"></i>Manage Shifts
            </a>
            <a href="{{ route('admin.locations.index') }}" class="block text-sm hover:underline">
              <i class="fas fa-map-marker-alt mr-2"></i>Manage Locations
            </a>
            <a href="{{ route('admin.roles.index') }}" class="block text-sm hover:underline">
              <i class="fas fa-user-tag mr-2"></i>Manage Roles
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="block text-sm hover:underline">
              <i class="fas fa-bullhorn mr-2"></i>Announcements
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection