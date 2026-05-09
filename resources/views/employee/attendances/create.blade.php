@extends('layouts.employee')

@section('page-title', 'Check In/Out')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">Check In / Check Out</h1>

    @if(session('success'))
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="flex-auto p-4">
                <p class="font-bold text-green-600">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="flex-auto p-4">
                <p class="font-bold text-red-500">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="flex flex-wrap -mx-3 mb-6">
        <!-- Check In Card -->
        <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700 text-2xl">Check In</h6>
                </div>
                <div class="flex-auto p-4">
                    @if($todayAttendance && $todayAttendance->check_in)
                        <div class="relative w-full px-5 py-5 mx-auto overflow-hidden bg-green-50 border border-solid shadow-none rounded-2xl border-green-100 bg-clip-border">
                            <p class="font-bold text-slate-700">Already checked in at {{ $todayAttendance->check_in }}</p>
                            <p class="text-sm text-slate-500">Status: {{ strtoupper($todayAttendance->status_hadir) }}</p>
                            @if($todayAttendance->menit_telat > 0)
                                <p class="text-sm text-red-500">Late by {{ $todayAttendance->menit_telat }} minutes</p>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('employee.attendances.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="font-bold text-slate-700 block mb-2">Select Location</label>
                                <select name="location_id" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required id="locationSelect">
                                    <option value="">Choose location...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4" id="mapContainer" style="height: 200px; display: none;">
                                <div id="map" style="height: 100%; width: 100%;"></div>
                            </div>
                            <input type="hidden" name="latitude" id="latitudeInput">
                            <input type="hidden" name="longitude" id="longitudeInput">
                            <button type="submit" class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro ease-soft-in tracking-tight-soft w-full text-lg">
                                Check In Now
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Check Out Card -->
        <div class="w-full max-w-full px-3 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700 text-2xl">Check Out</h6>
                </div>
                <div class="flex-auto p-4">
                    @if($todayAttendance && $todayAttendance->check_out)
                        <div class="relative w-full px-5 py-5 mx-auto overflow-hidden bg-green-50 border border-solid shadow-none rounded-2xl border-green-100 bg-clip-border">
                            <p class="font-bold text-slate-700">Already checked out at {{ $todayAttendance->check_out }}</p>
                            <p class="text-sm text-slate-500">Work Hours: {{ $todayAttendance->jam_kerja ?? '-' }}</p>
                            @if($todayAttendance->jam_lembur)
                                <p class="text-sm text-blue-500">Overtime: {{ $todayAttendance->jam_lembur }}</p>
                            @endif
                        </div>
                    @elseif($todayAttendance && $todayAttendance->check_in)
                        <form action="{{ route('employee.attendances.checkout') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <p class="font-bold text-slate-700">Checked in at: {{ $todayAttendance->check_in }}</p>
                                <p class="text-sm text-slate-500">Status: {{ strtoupper($todayAttendance->status_hadir) }}</p>
                            </div>
                            <div class="mb-4" id="mapContainerCheckout" style="height: 200px; display: none;">
                                <div id="mapCheckout" style="height: 100%; width: 100%;"></div>
                            </div>
                            <input type="hidden" name="latitude" id="latitudeInputCheckout">
                            <input type="hidden" name="longitude" id="longitudeInputCheckout">
                            <button type="submit" style="border: black solid 3px" class="inline-block px-6 py-3 mb-0 font-bold text-center text-black border-black uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-yellow-600 to-amber-400 leading-pro ease-soft-in tracking-tight-soft w-full text-lg">
                                Check Out Now
                            </button>
                        </form>
                    @else
                        <div class="relative w-full px-5 py-5 mx-auto overflow-hidden bg-gray-50 border border-solid shadow-none rounded-2xl border-gray-100 bg-clip-border">
                            <p class="font-bold text-slate-500">You need to check in first</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($userShift)
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700 text-2xl">Today's Shift</h6>
                </div>
                <div class="flex-auto p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Shift Name</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->nama_shift }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Start Time</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->jam_masuk }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">End Time</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->jam_pulang }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Late Tolerance</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->toleransi_telat_menit }} min</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($todayAttendance)
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700 text-2xl">Today's Attendance</h6>
                </div>
                <div class="flex-auto p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Status</p>
                            <h6 class="mb-1 font-bold text-slate-700">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl
                                    @if($todayAttendance->status_hadir == 'present') from-green-600 to-lime-400
                                    @elseif($todayAttendance->status_hadir == 'late') from-yellow-600 to-orange-400
                                    @else from-red-600 to-rose-400 @endif">
                                    {{ strtoupper($todayAttendance->status_hadir) }}
                                </span>
                            </h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Check In</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->check_in ?? '-' }}</h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Check Out</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->check_out ?? '-' }}</h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Work Hours</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->jam_kerja ?? '-' }}</h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Late (min)</p>
                            <h6 class="mb-1 font-bold text-red-500">{{ $todayAttendance->menit_telat ?? 0 }}</h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Early Out (min)</p>
                            <h6 class="mb-1 font-bold text-red-500">{{ $todayAttendance->menit_pulang_cepat ?? 0 }}</h6>
                        </div>
                        <div>
                            <p class="leading-tight text-sm text-slate-400">Overtime</p>
                            <h6 class="mb-1 font-bold text-blue-500">{{ $todayAttendance->jam_lembur ?? '-' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map for check-in
    var map = L.map('map').setView([0, 0], 2);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    var marker = null;
    
    // Function to set map view and add marker
    function setMapView(lat, lng) {
        map.setView([lat, lng], 15);
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
        
        // Update hidden inputs
        document.getElementById('latitudeInput').value = lat;
        document.getElementById('longitudeInput').value = lng;
    }
    
    // Show map container when form is visible
    document.getElementById('mapContainer').style.display = 'block';
    
    // Add click event to map to allow manual selection
    map.on('click', function(e) {
        setMapView(e.latlng.lat, e.latlng.lng);
    });
    
    // Try to get user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            setMapView(lat, lng);
        }, function(error) {
            console.log("Geolocation failed: ", error);
            // Default to center of Indonesia if geolocation fails
            setMapView(-6.2088, 106.8456);
        });
    } else {
        // Geolocation not supported
        setMapView(-6.2088, 106.8456);
    }
    
    // Initialize map for check-out
    var mapCheckout = L.map('mapCheckout').setView([0, 0], 2);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mapCheckout);
    
    var markerCheckout = null;
    
    // Function to set map view and add marker for checkout
    function setMapViewCheckout(lat, lng) {
        mapCheckout.setView([lat, lng], 15);
        if (markerCheckout) {
            markerCheckout.setLatLng([lat, lng]);
        } else {
            markerCheckout = L.marker([lat, lng]).addTo(mapCheckout);
        }
        
        // Update hidden inputs
        document.getElementById('latitudeInputCheckout').value = lat;
        document.getElementById('longitudeInputCheckout').value = lng;
    }
    
    // Show map container for checkout
    document.getElementById('mapContainerCheckout').style.display = 'block';
    
    // Add click event to map to allow manual selection for checkout
    mapCheckout.on('click', function(e) {
        setMapViewCheckout(e.latlng.lat, e.latlng.lng);
    });
    
    // Try to get user's current location for checkout
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            setMapViewCheckout(lat, lng);
        }, function(error) {
            console.log("Geolocation failed: ", error);
            // Default to center of Indonesia if geolocation fails
            setMapViewCheckout(-6.2088, 106.8456);
        });
    } else {
        // Geolocation not supported
        setMapViewCheckout(-6.2088, 106.8456);
    }
});
</script>
@endpush