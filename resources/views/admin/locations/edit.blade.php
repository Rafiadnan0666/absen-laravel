@extends('admin.dashboard.layout')

@section('title', 'Edit Location - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">EDIT LOCATION</h6>
    </div>
    <div>
      <form action="{{ route('admin.locations.update', $location) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label for="nama_lokasi" class="neo-label">LOCATION NAME</label>
          <input type="text" id="nama_lokasi" name="nama_lokasi" value="{{ old('nama_lokasi', $location->nama_lokasi) }}"
            class="neo-input" placeholder="Enter location name" required>
          @error('nama_lokasi')
            <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="mb-4">
          <label for="latitude" class="neo-label">LATITUDE</label>
          <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}"
            class="neo-input" placeholder="Enter latitude (-90 to 90)" required>
          @error('latitude')
            <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="mb-4">
          <label for="longitude" class="neo-label">LONGITUDE</label>
          <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}"
            class="neo-input" placeholder="Enter longitude (-180 to 180)" required>
          @error('longitude')
            <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="mb-4">
          <label for="radius_meter" class="neo-label">RADIUS (METERS)</label>
          <input type="number" id="radius_meter" name="radius_meter" value="{{ old('radius_meter', $location->radius_meter) }}"
            class="neo-input" placeholder="Enter radius in meters" required>
          @error('radius_meter')
            <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div class="flex justify-end space-x-2">
          <a href="{{ route('admin.locations.index') }}" class="neo-btn-secondary">
            CANCEL
          </a>
          <button type="submit" class="neo-btn-primary">
            UPDATE
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection