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
                        <form action="{{ route('employee.attendances.store') }}" method="POST" id="checkInForm">
                            @csrf
                            <div class="mb-4">
                                <label class="font-bold text-slate-700 block mb-2">Select Location</label>
                                <select name="location_id" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required>
                                    <option value="">Choose location...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <button type="button" id="getLocationBtn" class="inline-flex items-center justify-center px-4 py-2 mb-0 font-bold text-center text-purple-700 uppercase align-middle transition-all bg-transparent border border-solid border-purple-500 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 text-white w-full">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Get My Location
                                </button>
                            </div>
                            
                            <div class="mb-4">
                                <div id="locationStatus" class="text-sm text-slate-500 mb-2"></div>
                                <div id="mapContainer" class="h-64 rounded-lg border border-slate-200" style="display: none;">
                                    <div id="map" class="h-full w-full rounded-lg"></div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="latitude" id="latitudeInput">
                            <input type="hidden" name="longitude" id="longitudeInput">
                            
                            <button type="submit" disabled class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro ease-soft-in tracking-tight-soft w-full text-lg opacity-50 cursor-not-allowed">
                                <i class="fas fa-sign-in-alt mr-2"></i> Check In Now
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
                        <form action="{{ route('employee.attendances.checkout') }}" method="POST" id="checkOutForm">
                            @csrf
                            <div class="mb-4">
                                <p class="font-bold text-slate-700">Checked in at: {{ $todayAttendance->check_in }}</p>
                                <p class="text-sm text-slate-500">Status: {{ strtoupper($todayAttendance->status_hadir) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <button type="button" id="getLocationBtnCheckout" class="inline-flex items-center justify-center px-4 py-2 mb-0 font-bold text-center text-purple-700 uppercase align-middle transition-all bg-transparent border border-solid border-purple-500 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 text-white w-full">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Get My Location
                                </button>
                            </div>
                            
                            <div class="mb-4">
                                <div id="locationStatusCheckout" class="text-sm text-slate-500 mb-2"></div>
                                <div id="mapContainerCheckout" class="h-64 rounded-lg border border-slate-200" style="display: none;">
                                    <div id="mapCheckout" class="h-full w-full rounded-lg"></div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="latitude" id="latitudeInputCheckout">
                            <input type="hidden" name="longitude" id="longitudeInputCheckout">
                             <button type="submit" disabled class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-blue-600 to-indigo-500 leading-pro ease-soft-in tracking-tight-soft w-full text-lg opacity-50 cursor-not-allowed">
                                <i class="fas fa-sign-out-alt mr-2"></i> Check Out Now
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
                                     @elseif($todayAttendance->status_hadir == 'late') from-blue-600 to-indigo-500
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
    var locations = @json($locationsJson);
    var checkinLocation = @json($checkinLocation ? [
        'id' => $checkinLocation->id,
        'nama_lokasi' => $checkinLocation->nama_lokasi,
        'latitude' => (float) $checkinLocation->latitude,
        'longitude' => (float) $checkinLocation->longitude,
        'radius_meter' => $checkinLocation->radius_meter ?? 100,
    ] : null);

    function fmtDistance(meters) {
        return meters >= 1000 ? (meters / 1000).toFixed(2) + ' km' : Math.round(meters) + ' m';
    }

    function calculateDistance(lat1, lng1, lat2, lng2) {
        var R = 6371000;
        var dLat = (lat2 - lat1) * Math.PI / 180;
        var dLng = (lng2 - lng1) * Math.PI / 180;
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function fetchRoute(lat1, lng1, lat2, lng2, callback) {
        var url = 'https://router.project-osrm.org/route/v1/driving/'
            + lng1 + ',' + lat1 + ';' + lng2 + ',' + lat2
            + '?overview=full&geometries=geojson&steps=false&alternatives=false';
        fetch(url)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                    callback(null, data.routes[0]);
                } else {
                    callback(new Error('No route found'), null);
                }
            })
            .catch(function(err) { callback(err, null); });
    }

    function drawStatusBox(el, withinRadius, straightDist, roadDist, radiusMeters, locName, isCheckout) {
        var radiusText = fmtDistance(radiusMeters);
        var html = '<div class="mt-2 p-3 rounded-lg ' + (withinRadius ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200') + '">';
        html += '<p class="font-bold">';
        if (withinRadius) {
            html += '<i class="fas fa-check-circle mr-1"></i> You are at ' + locName;
        } else {
            html += '<i class="fas fa-times-circle mr-1"></i> You are too far from ' + locName;
        }
        html += '</p>';
        html += '<p class="text-sm mt-1"><i class="fas fa-arrows-alt-h mr-1"></i> Straight-line: <strong>' + fmtDistance(straightDist) + '</strong></p>';
        if (roadDist !== null) {
            html += '<p class="text-sm"><i class="fas fa-road mr-1"></i> By road: <strong>' + fmtDistance(roadDist) + '</strong></p>';
        } else {
            html += '<p class="text-sm text-slate-400"><i class="fas fa-spinner fa-spin mr-1"></i> Loading road route...</p>';
        }
        html += '<p class="text-sm mt-1">Max allowed radius: ' + radiusText + '</p>';
        html += '</div>';
        el.innerHTML = html;
    }

    function setSubmitState(btn, enabled) {
        btn.disabled = !enabled;
        if (enabled) {
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function latLngBounds(lat1, lng1, lat2, lng2) {
        return L.latLngBounds(
            [Math.min(lat1, lat2), Math.min(lng1, lng2)],
            [Math.max(lat1, lat2), Math.max(lng1, lng2)]
        );
    }

    // ----- Check-in -----
    var map, checkInUserMarker, checkInLocMarker, checkInCircle, checkInStraightLine, checkInRoadLine;
    var mapInitialized = false;
    var userLat = null, userLng = null;
    var selectedLocation = null;

    function clearCheckInLayers() {
        if (checkInUserMarker) { map.removeLayer(checkInUserMarker); checkInUserMarker = null; }
        if (checkInLocMarker) { map.removeLayer(checkInLocMarker); checkInLocMarker = null; }
        if (checkInCircle) { map.removeLayer(checkInCircle); checkInCircle = null; }
        if (checkInStraightLine) { map.removeLayer(checkInStraightLine); checkInStraightLine = null; }
        if (checkInRoadLine) { map.removeLayer(checkInRoadLine); checkInRoadLine = null; }
    }

    function updateCheckInMap() {
        if (!userLat || !selectedLocation) return;

        document.getElementById('mapContainer').style.display = 'block';

        if (!mapInitialized) {
            map = L.map('map', { zoomControl: true, scrollWheelZoom: true }).setView([userLat, userLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            mapInitialized = true;
            setTimeout(function() { map.invalidateSize(); }, 100);
        }

        clearCheckInLayers();

        var locLat = selectedLocation.latitude;
        var locLng = selectedLocation.longitude;
        var straightDist = calculateDistance(userLat, userLng, locLat, locLng);
        var radius = selectedLocation.radius_meter;
        var withinRadius = straightDist <= radius;
        var color = withinRadius ? '#22c55e' : '#ef4444';

        checkInUserMarker = L.marker([userLat, userLng], { draggable: true }).addTo(map);
        checkInUserMarker.bindTooltip('<b>You</b><br>' + userLat.toFixed(5) + ', ' + userLng.toFixed(5), { direction: 'top' });
        checkInUserMarker.on('dragend', function(e) {
            var pos = e.target.getLatLng();
            userLat = pos.lat;
            userLng = pos.lng;
            document.getElementById('latitudeInput').value = userLat;
            document.getElementById('longitudeInput').value = userLng;
            updateCheckInMap();
        });

        checkInLocMarker = L.marker([locLat, locLng]).addTo(map);
        checkInLocMarker.bindTooltip('<b>' + selectedLocation.nama_lokasi + '</b><br>Radius: ' + fmtDistance(radius), { direction: 'top' });

        checkInCircle = L.circle([locLat, locLng], {
            radius: radius,
            color: color,
            fillColor: color,
            fillOpacity: 0.12,
            weight: 2,
        }).addTo(map);

        checkInStraightLine = L.polyline([[userLat, userLng], [locLat, locLng]], {
            color: '#6b7280',
            dashArray: '6, 6',
            weight: 2,
            opacity: 0.5,
        }).addTo(map);

        map.fitBounds(latLngBounds(userLat, userLng, locLat, locLng), { padding: [60, 60] });

        document.getElementById('latitudeInput').value = userLat;
        document.getElementById('longitudeInput').value = userLng;

        var statusEl = document.getElementById('locationStatus');
        drawStatusBox(statusEl, withinRadius, straightDist, null, radius, selectedLocation.nama_lokasi, false);

        var submitBtn = document.querySelector('#checkInForm button[type="submit"]');
        setSubmitState(submitBtn, withinRadius);

        fetchRoute(userLat, userLng, locLat, locLng, function(err, route) {
            if (err || !route) return;

            var coords = route.geometry.coordinates.map(function(c) { return [c[1], c[0]]; });
            checkInRoadLine = L.polyline(coords, {
                color: '#3b82f6',
                weight: 4,
                opacity: 0.8,
            }).addTo(map);

            var roadDistance = route.distance;
            drawStatusBox(statusEl, withinRadius, straightDist, roadDistance, radius, selectedLocation.nama_lokasi, false);
        });
    }

    var locationSelect = document.querySelector('[name="location_id"]');
    locationSelect.addEventListener('change', function() {
        var id = parseInt(this.value);
        selectedLocation = id ? locations.find(function(l) { return l.id === id; }) : null;
        if (selectedLocation && userLat) {
            updateCheckInMap();
        } else if (!selectedLocation && mapInitialized) {
            clearCheckInLayers();
            document.getElementById('locationStatus').innerHTML = '';
        }
    });

    document.getElementById('getLocationBtn').addEventListener('click', function() {
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Getting location...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                document.getElementById('latitudeInput').value = userLat;
                document.getElementById('longitudeInput').value = userLng;

                if (selectedLocation) {
                    updateCheckInMap();
                } else {
                    document.getElementById('mapContainer').style.display = 'block';
                    if (!mapInitialized) {
                        map = L.map('map', { zoomControl: true, scrollWheelZoom: true }).setView([userLat, userLng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(map);
                        mapInitialized = true;
                        setTimeout(function() { map.invalidateSize(); }, 100);
                    }
                    checkInUserMarker = L.marker([userLat, userLng], { draggable: true }).addTo(map);
                    checkInUserMarker.bindTooltip('<b>You</b><br>' + userLat.toFixed(5) + ', ' + userLng.toFixed(5), { direction: 'top' });
                    checkInUserMarker.on('dragend', function(e) {
                        var pos = e.target.getLatLng();
                        userLat = pos.lat;
                        userLng = pos.lng;
                        document.getElementById('latitudeInput').value = userLat;
                        document.getElementById('longitudeInput').value = userLng;
                        if (selectedLocation) updateCheckInMap();
                    });
                    map.setView([userLat, userLng], 15);
                    document.getElementById('locationStatus').innerHTML = '<i class="fas fa-check-circle text-green-500"></i> Location found! Now select a location above.';
                }
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check mr-2"></i> Location Found';
            }, function(error) {
                document.getElementById('locationStatus').innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> ' + error.message;
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Get My Location';
            }, { enableHighAccuracy: true, timeout: 10000 });
        } else {
            document.getElementById('locationStatus').innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> Geolocation not supported';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Get My Location';
        }
    });

    // ----- Check-out -----
    var mapCheckout, checkOutUserMarker, checkOutLocMarker, checkOutCircle, checkOutStraightLine, checkOutRoadLine;
    var mapCheckoutInitialized = false;
    var checkOutUserLat = null, checkOutUserLng = null;

    function clearCheckOutLayers() {
        if (checkOutUserMarker) { mapCheckout.removeLayer(checkOutUserMarker); checkOutUserMarker = null; }
        if (checkOutLocMarker) { mapCheckout.removeLayer(checkOutLocMarker); checkOutLocMarker = null; }
        if (checkOutCircle) { mapCheckout.removeLayer(checkOutCircle); checkOutCircle = null; }
        if (checkOutStraightLine) { mapCheckout.removeLayer(checkOutStraightLine); checkOutStraightLine = null; }
        if (checkOutRoadLine) { mapCheckout.removeLayer(checkOutRoadLine); checkOutRoadLine = null; }
    }

    function updateCheckOutMap() {
        if (!checkOutUserLat || !checkinLocation) return;

        document.getElementById('mapContainerCheckout').style.display = 'block';

        if (!mapCheckoutInitialized) {
            mapCheckout = L.map('mapCheckout', { zoomControl: true, scrollWheelZoom: true }).setView([checkOutUserLat, checkOutUserLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapCheckout);
            mapCheckoutInitialized = true;
            setTimeout(function() { mapCheckout.invalidateSize(); }, 100);
        }

        clearCheckOutLayers();

        var locLat = checkinLocation.latitude;
        var locLng = checkinLocation.longitude;
        var straightDist = calculateDistance(checkOutUserLat, checkOutUserLng, locLat, locLng);
        var radius = checkinLocation.radius_meter;
        var withinRadius = straightDist <= radius;
        var color = withinRadius ? '#22c55e' : '#ef4444';

        checkOutUserMarker = L.marker([checkOutUserLat, checkOutUserLng], { draggable: true }).addTo(mapCheckout);
        checkOutUserMarker.bindTooltip('<b>You</b><br>' + checkOutUserLat.toFixed(5) + ', ' + checkOutUserLng.toFixed(5), { direction: 'top' });
        checkOutUserMarker.on('dragend', function(e) {
            var pos = e.target.getLatLng();
            checkOutUserLat = pos.lat;
            checkOutUserLng = pos.lng;
            document.getElementById('latitudeInputCheckout').value = checkOutUserLat;
            document.getElementById('longitudeInputCheckout').value = checkOutUserLng;
            updateCheckOutMap();
        });

        checkOutLocMarker = L.marker([locLat, locLng]).addTo(mapCheckout);
        checkOutLocMarker.bindTooltip('<b>' + checkinLocation.nama_lokasi + '</b><br>Radius: ' + fmtDistance(radius), { direction: 'top' });

        checkOutCircle = L.circle([locLat, locLng], {
            radius: radius,
            color: color,
            fillColor: color,
            fillOpacity: 0.12,
            weight: 2,
        }).addTo(mapCheckout);

        checkOutStraightLine = L.polyline([[checkOutUserLat, checkOutUserLng], [locLat, locLng]], {
            color: '#6b7280',
            dashArray: '6, 6',
            weight: 2,
            opacity: 0.5,
        }).addTo(mapCheckout);

        mapCheckout.fitBounds(latLngBounds(checkOutUserLat, checkOutUserLng, locLat, locLng), { padding: [60, 60] });

        document.getElementById('latitudeInputCheckout').value = checkOutUserLat;
        document.getElementById('longitudeInputCheckout').value = checkOutUserLng;

        var statusEl = document.getElementById('locationStatusCheckout');
        drawStatusBox(statusEl, withinRadius, straightDist, null, radius, checkinLocation.nama_lokasi, true);

        var submitBtn = document.querySelector('#checkOutForm button[type="submit"]');
        setSubmitState(submitBtn, withinRadius);

        fetchRoute(checkOutUserLat, checkOutUserLng, locLat, locLng, function(err, route) {
            if (err || !route) return;

            var coords = route.geometry.coordinates.map(function(c) { return [c[1], c[0]]; });
            checkOutRoadLine = L.polyline(coords, {
                color: '#3b82f6',
                weight: 4,
                opacity: 0.8,
            }).addTo(mapCheckout);

            drawStatusBox(statusEl, withinRadius, straightDist, route.distance, radius, checkinLocation.nama_lokasi, true);
        });
    }

    document.getElementById('getLocationBtnCheckout').addEventListener('click', function() {
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Getting location...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                checkOutUserLat = position.coords.latitude;
                checkOutUserLng = position.coords.longitude;
                document.getElementById('latitudeInputCheckout').value = checkOutUserLat;
                document.getElementById('longitudeInputCheckout').value = checkOutUserLng;

                if (checkinLocation) {
                    updateCheckOutMap();
                } else {
                    document.getElementById('mapContainerCheckout').style.display = 'block';
                    if (!mapCheckoutInitialized) {
                        mapCheckout = L.map('mapCheckout', { zoomControl: true, scrollWheelZoom: true }).setView([checkOutUserLat, checkOutUserLng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(mapCheckout);
                        mapCheckoutInitialized = true;
                        setTimeout(function() { mapCheckout.invalidateSize(); }, 100);
                    }
                    checkOutUserMarker = L.marker([checkOutUserLat, checkOutUserLng], { draggable: true }).addTo(mapCheckout);
                    checkOutUserMarker.bindTooltip('<b>You</b><br>' + checkOutUserLat.toFixed(5) + ', ' + checkOutUserLng.toFixed(5), { direction: 'top' });
                    checkOutUserMarker.on('dragend', function(e) {
                        var pos = e.target.getLatLng();
                        checkOutUserLat = pos.lat;
                        checkOutUserLng = pos.lng;
                        document.getElementById('latitudeInputCheckout').value = checkOutUserLat;
                        document.getElementById('longitudeInputCheckout').value = checkOutUserLng;
                        if (checkinLocation) updateCheckOutMap();
                    });
                    mapCheckout.setView([checkOutUserLat, checkOutUserLng], 15);
                    document.getElementById('locationStatusCheckout').innerHTML = '<i class="fas fa-check-circle text-green-500"></i> Location found!';
                }
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check mr-2"></i> Location Found';
            }, function(error) {
                document.getElementById('locationStatusCheckout').innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> ' + error.message;
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Get My Location';
            }, { enableHighAccuracy: true, timeout: 10000 });
        } else {
            document.getElementById('locationStatusCheckout').innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> Geolocation not supported';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-map-marker-alt mr-2"></i> Get My Location';
        }
    });
});
</script>
@endpush