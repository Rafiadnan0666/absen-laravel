@extends('admin.dashboard.layout')

@section('title', 'Edit Location - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">EDIT LOCATION</h6>
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="latitude" class="neo-label">LATITUDE</label>
            <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}"
              class="neo-input" placeholder="Click map or enter value" required>
            @error('latitude')
              <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="longitude" class="neo-label">LONGITUDE</label>
            <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}"
              class="neo-input" placeholder="Click map or enter value" required>
            @error('longitude')
              <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
        </div>
        
        <div class="mb-4">
          <label class="neo-label">PICK LOCATION ON MAP</label>
          <div class="mb-2">
            <input type="text" id="address-search" 
              class="neo-input" placeholder="Search address...">
          </div>
          <div id="map" class="border-3 border-black shadow-neo" style="height: 400px; border-radius: 0; z-index: 1;"></div>
          <p class="text-sm text-gray-600 mt-2 font-semibold"><i class="fas fa-info-circle mr-1"></i>Click on the map to set coordinates. The circle shows the radius.</p>
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
    color: '#000000',
    fillColor: '#ff6b6b',
    fillOpacity: 0.25,
    weight: 3,
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
