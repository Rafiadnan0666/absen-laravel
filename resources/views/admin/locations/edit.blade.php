@extends('admin.dashboard.layout')

@section('title', 'Edit Location - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Location</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="nama_lokasi" class="inline-block mb-2 text-sm font-bold text-slate-700">Location Name</label>
            <input type="text" id="nama_lokasi" name="nama_lokasi" value="{{ old('nama_lokasi', $location->nama_lokasi) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter location name" required>
            @error('nama_lokasi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="latitude" class="inline-block mb-2 text-sm font-bold text-slate-700">Latitude</label>
              <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Click map or enter value" required>
              @error('latitude')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label for="longitude" class="inline-block mb-2 text-sm font-bold text-slate-700">Longitude</label>
              <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Click map or enter value" required>
              @error('longitude')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>
          
          <div class="mb-4">
            <label class="inline-block mb-2 text-sm font-bold text-slate-700">Pick Location on Map</label>
            <div class="mb-2">
              <input type="text" id="address-search" 
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Search address...">
            </div>
            <div id="map" style="height: 400px; border-radius: 0.5rem; z-index: 1;"></div>
            <p class="text-xs text-slate-500 mt-1"><i class="fas fa-info-circle mr-1"></i>Click on the map to set coordinates. The circle shows the radius.</p>
          </div>
          
          <div class="mb-4">
            <label for="radius_meter" class="inline-block mb-2 text-sm font-bold text-slate-700">Radius (meters)</label>
            <input type="number" id="radius_meter" name="radius_meter" value="{{ old('radius_meter', $location->radius_meter) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter radius in meters" required>
            @error('radius_meter')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <a href="{{ route('admin.locations.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
              Cancel
            </a>
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

@push('scripts')
<script>
(function() {
  var defaultLat = {{ old('latitude', $location->latitude ?? -6.2088) }};
  var defaultLng = {{ old('longitude', $location->longitude ?? 106.8456) }};
  var defaultRadius = {{ old('radius_meter', $location->radius_meter ?? 100) }};
  
  var map = L.map('map').setView([defaultLat, defaultLng], 15);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);
  
  var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
  var circle = L.circle([defaultLat, defaultLng], {
    color: '#7c3aed',
    fillColor: '#7c3aed',
    fillOpacity: 0.15,
    radius: defaultRadius
  }).addTo(map);
  
  function updateInputs(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
  }
  
  function updateCircle() {
    var lat = parseFloat(document.getElementById('latitude').value) || defaultLat;
    var lng = parseFloat(document.getElementById('longitude').value) || defaultLng;
    var radius = parseInt(document.getElementById('radius_meter').value) || defaultRadius;
    
    marker.setLatLng([lat, lng]);
    circle.setLatLng([lat, lng]);
    circle.setRadius(radius);
  }
  
  marker.on('drag', function(e) {
    var pos = e.target.getLatLng();
    updateInputs(pos.lat, pos.lng);
    circle.setLatLng(pos);
  });
  
  map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    circle.setLatLng(e.latlng);
    updateInputs(e.latlng.lat, e.latlng.lng);
  });
  
  document.getElementById('radius_meter').addEventListener('input', updateCircle);
  
  document.getElementById('latitude').addEventListener('change', function() {
    updateCircle();
    map.setView([parseFloat(this.value) || defaultLat, parseFloat(document.getElementById('longitude').value) || defaultLng]);
  });
  
  document.getElementById('longitude').addEventListener('change', function() {
    updateCircle();
    map.setView([parseFloat(document.getElementById('latitude').value) || defaultLat, parseFloat(this.value) || defaultLng]);
  });
  
  var geocoder = new L.Control.Geocoder.Nominatim();
  var searchInput = document.getElementById('address-search');
  var searchTimeout;
  
  searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    var query = this.value.trim();
    
    if (query.length < 3) return;
    
    searchTimeout = setTimeout(function() {
      geocoder.geocode(query, function(results) {
        if (results && results.length > 0) {
          var result = results[0];
          var lat = result.center.lat || result.center[0];
          var lng = result.center.lng || result.center[1];
          
          map.setView([lat, lng], 16);
          marker.setLatLng([lat, lng]);
          circle.setLatLng([lat, lng]);
          updateInputs(lat, lng);
        }
      });
    }, 500);
  });
})();
</script>
@endpush
@endsection
