@extends('layouts.employee')

@section('page-title', 'Check In/Out')

@push('styles')
<style>
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    .toast { padding: 14px 20px; border: 3px solid #000; font-weight: 700; font-size: 14px; margin-bottom: 10px; box-shadow: 4px 4px 0 #000; transform: translateX(400px); transition: transform 0.3s ease; }
    .toast.show { transform: translateX(0); }
    .toast-success { background: #00f5d4; color: #000; }
    .toast-error { background: #e63946; color: #fff; }
    .toast-info { background: #00bbf9; color: #000; }
    .location-box { padding: 16px; border: 3px solid #000; margin-top: 12px; font-size: 14px; }
    .location-box.success { background: #d1fae5; }
    .location-box.error { background: #fee2e2; }
    .location-box.loading { background: #e0e7ff; }
    .location-box.warning { background: #fef9c3; }
    .map-frame { height: 220px; margin-top: 12px; border: 3px solid #000; overflow: hidden; }
    .radius-indicator { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 2px solid #000; font-weight: 700; font-size: 13px; margin-top: 8px; }
    .radius-indicator.inside { background: #d1fae5; }
    .radius-indicator.outside { background: #fee2e2; }
    .location-select-loading { opacity: 0.5; pointer-events: none; }
</style>
@endpush

@section('content')
    <h1 class="neo-section-title">Check In / Check Out</h1>

    <div id="toastContainer" class="toast-container"></div>

    @if(session('success'))
    <div class="neo-alert-success mb-6 fade-in-up">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="neo-alert-danger mb-6 shake">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="neo-card p-6 fade-in-up fade-in-up-d1">
            <h3 class="neo-label text-lg mb-4 flex items-center gap-2">
                <span class="float">📥</span> CHECK IN
            </h3>
            
            @if($todayAttendance && $todayAttendance->check_in)
                <div class="neo-card-green p-4 bounce-in">
                    <p class="font-bold">Checked in at {{ $todayAttendance->check_in->format('H:i') }}</p>
                    <p class="text-sm mt-1">Status: <span class="font-bold">{{ strtoupper($todayAttendance->status_hadir) }}</span></p>
                    @if($todayAttendance->menit_telat > 0)
                        <p class="text-sm text-neo-red mt-1">Late: {{ $todayAttendance->menit_telat }} minutes</p>
                    @endif
                    @if($todayAttendance->location)
                        <p class="text-sm mt-1">📍 {{ $todayAttendance->location->nama_lokasi }}</p>
                    @endif
                </div>
            @else
                <form action="{{ route('employee.attendances.store') }}" method="POST" id="checkinForm">
                    @csrf
                    <div class="neo-form-group">
                        <label class="neo-label">Office Location</label>
                        <select name="location_id" id="locationSelect" class="neo-select" required onchange="onLocationChange()">
                            <option value="">Select office...</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}"
                                    data-lat="{{ $location->latitude }}"
                                    data-lng="{{ $location->longitude }}"
                                    data-radius="{{ $location->radius_meter }}">
                                    {{ $location->nama_lokasi }} ({{ $location->radius_meter }}m radius)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div id="locationInfo" class="mb-3" style="display:none;">
                        <div class="location-box success">
                            <span id="locationInfoText"></span>
                        </div>
                    </div>
                    
                    <button type="button" id="btnGetLocationCheckin" class="neo-btn-secondary w-full mb-3" onclick="getLocationCheckin()">
                        📍 Get My GPS Location
                    </button>
                    
                    <div id="statusCheckin" style="display:none;" class="location-box mb-3"></div>
                    <div id="radiusIndicator" style="display:none;" class="radius-indicator"></div>
                    <div id="mapCheckinBox" class="map-frame" style="display:none;">
                        <div id="mapCheckin" style="width:100%;height:100%;"></div>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latCheckin" value="">
                    <input type="hidden" name="longitude" id="lngCheckin" value="">
                    <input type="hidden" id="withinRadius" value="false">
                    
                    <button type="submit" id="submitCheckin" class="neo-btn-green w-full text-lg py-4 pulse-glow" disabled>
                        ⏱️ Check In Now
                    </button>
                    <p id="checkinHelp" class="text-xs font-bold mt-2 text-center">Select a location and capture your GPS to enable check-in</p>
                </form>
            @endif
        </div>

        <div class="neo-card p-6 fade-in-up fade-in-up-d2">
            <h3 class="neo-label text-lg mb-4 flex items-center gap-2">
                <span class="float" style="animation-delay:1s;">📤</span> CHECK OUT
            </h3>
            
            @if($todayAttendance && $todayAttendance->check_out)
                <div class="neo-card-green p-4 bounce-in">
                    <p class="font-bold">Checked out at {{ $todayAttendance->check_out->format('H:i') }}</p>
                    <p class="text-sm mt-1">Work Hours: {{ $todayAttendance->jam_kerja ? $todayAttendance->jam_kerja->format('H:i') : '-' }}</p>
                    @if($todayAttendance->jam_lembur)
                        <p class="text-sm text-neo-cyan mt-1">Overtime: {{ $todayAttendance->jam_lembur->format('H:i') }}</p>
                    @endif
                </div>
            @elseif($todayAttendance && $todayAttendance->check_in)
                <form action="{{ route('employee.attendances.checkout') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="neo-card-purple p-4 mb-4">
                        <p class="font-bold">Checked in at: {{ $todayAttendance->check_in->format('H:i') }}</p>
                        <p class="text-sm">Status: {{ strtoupper($todayAttendance->status_hadir) }}</p>
                        @if($todayAttendance->menit_telat > 0)
                            <p class="text-sm text-neo-red">Late: {{ $todayAttendance->menit_telat }} min</p>
                        @endif
                    </div>
                    
                    <button type="button" id="btnGetLocationCheckout" class="neo-btn-secondary w-full mb-3" onclick="getLocationCheckout()">
                        📍 Get My GPS Location
                    </button>
                    
                    <div id="statusCheckout" style="display:none;" class="location-box mb-3"></div>
                    <div id="radiusIndicatorOut" style="display:none;" class="radius-indicator"></div>
                    <div id="mapCheckoutBox" class="map-frame" style="display:none;">
                        <div id="mapCheckout" style="width:100%;height:100%;"></div>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latCheckout" value="">
                    <input type="hidden" name="longitude" id="lngCheckout" value="">
                    <input type="hidden" id="withinRadiusOut" value="false">
                    
                    <button type="submit" id="submitCheckout" class="neo-btn-pink w-full text-lg py-4 pulse-glow" disabled>
                        ⏱️ Check Out Now
                    </button>
                    <p id="checkoutHelp" class="text-xs font-bold mt-2 text-center">Capture your GPS location to enable check-out</p>
                </form>
            @else
                <div class="neo-card p-4 text-center">
                    <p class="font-bold mb-2">Please check in first</p>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            @endif
        </div>
    </div>

    @if($userShift)
    <div class="neo-card p-6 mb-6 fade-in-up fade-in-up-d3">
        <h3 class="neo-label text-lg mb-4">Today's Shift</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="neo-card text-center"><p class="neo-label mb-1">Shift</p><p class="font-bold">{{ $userShift->shift->nama_shift }}</p></div>
            <div class="neo-card text-center"><p class="neo-label mb-1">Start</p><p class="font-bold">{{ $userShift->shift->jam_masuk }}</p></div>
            <div class="neo-card text-center"><p class="neo-label mb-1">End</p><p class="font-bold">{{ $userShift->shift->jam_pulang }}</p></div>
            <div class="neo-card text-center"><p class="neo-label mb-1">Tolerance</p><p class="font-bold">{{ $userShift->shift->toleransi_telat_menit }} min</p></div>
        </div>
    </div>
    @endif

    @if($todayAttendance)
    <div class="neo-card p-6 mb-6 fade-in-up fade-in-up-d3">
        <h3 class="neo-label text-lg mb-4">Today's Attendance</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="neo-card"><p class="neo-label mb-1">Status</p><p class="font-bold">{{ strtoupper($todayAttendance->status_hadir) }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Check In</p><p class="font-bold">{{ $todayAttendance->check_in ? $todayAttendance->check_in->format('H:i') : '-' }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Check Out</p><p class="font-bold">{{ $todayAttendance->check_out ? $todayAttendance->check_out->format('H:i') : '-' }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Work Hours</p><p class="font-bold">{{ $todayAttendance->jam_kerja ? $todayAttendance->jam_kerja->format('H:i') : '-' }}</p></div>
        </div>
    </div>
    @endif

    @if(isset($upcomingHolidays) && $upcomingHolidays->count() > 0)
    <div class="neo-card-yellow p-6 mb-6 fade-in-up fade-in-up-d4">
        <h3 class="neo-label text-lg mb-4 flex items-center gap-2">🎉 UPCOMING HOLIDAYS</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            @foreach($upcomingHolidays as $holiday)
            <div class="neo-card text-center p-3">
                <p class="text-2xl font-black">{{ $holiday->tanggal->format('d') }}</p>
                <p class="text-xs font-bold">{{ $holiday->tanggal->format('M') }}</p>
                <p class="text-sm font-bold mt-1">{{ $holiday->nama_hari_libur }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($stats))
    <div class="neo-card p-6 mb-6 fade-in-up fade-in-up-d4">
        <h3 class="neo-label text-lg mb-4">📊 THIS MONTH'S STATS</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="neo-card-green text-center p-4">
                <p class="neo-label">Present</p>
                <p class="text-2xl font-black">{{ $stats['present_days'] }}</p>
            </div>
            <div class="neo-card-yellow text-center p-4">
                <p class="neo-label">Late</p>
                <p class="text-2xl font-black">{{ $stats['late_days'] }}</p>
            </div>
            <div class="neo-card-red text-center p-4">
                <p class="neo-label">Absent</p>
                <p class="text-2xl font-black">{{ $stats['absent_days'] }}</p>
            </div>
            <div class="neo-card-cyan text-center p-4">
                <p class="neo-label">Work Hours</p>
                <p class="text-lg font-black">{{ $stats['total_work_hours'] }}</p>
            </div>
            <div class="neo-card-purple text-center p-4">
                <p class="neo-label">Overtime</p>
                <p class="text-lg font-black">{{ $stats['total_overtime'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex justify-between items-center mb-1">
                <span class="text-sm font-bold">Attendance Rate</span>
                <span class="text-sm font-bold">{{ $stats['attendance_rate'] }}%</span>
            </div>
            <div class="progress-bar-neo">
                <div class="progress-bar-fill" style="width: {{ $stats['attendance_rate'] }}%"></div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
    function showToast(msg, type) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = msg;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(()=>toast.remove(),300); }, 3500);
    }

    // Haversine formula for distance calculation
    function calcDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                 Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                 Math.sin(dLng/2) * Math.sin(dLng/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    var selectedLocation = null;
    var checkinLocation = null;

    function onLocationChange() {
        const select = document.getElementById('locationSelect');
        const opt = select.options[select.selectedIndex];
        if (opt.value) {
            selectedLocation = {
                id: opt.value,
                name: opt.text.split(' (')[0],
                lat: parseFloat(opt.dataset.lat),
                lng: parseFloat(opt.dataset.lng),
                radius: parseInt(opt.dataset.radius)
            };
            document.getElementById('locationInfo').style.display = 'block';
            document.getElementById('locationInfoText').innerHTML =
                `📍 <strong>${selectedLocation.name}</strong> — ${selectedLocation.radius}m radius allowed`;
        } else {
            selectedLocation = null;
            document.getElementById('locationInfo').style.display = 'none';
        }
        resetCheckinValidation();
    }

    function resetCheckinValidation() {
        document.getElementById('withinRadius').value = 'false';
        document.getElementById('submitCheckin').disabled = true;
        document.getElementById('checkinHelp').textContent = selectedLocation
            ? 'Capture your GPS to verify you\'re at the office'
            : 'Select a location and capture your GPS to enable check-in';
    }

    // --- CHECK-IN GPS ---
    var mapCheckin, markerCheckin, circleCheckin, mapInitCheckin = false;

    function getLocationCheckin() {
        const btn = document.getElementById('btnGetLocationCheckin');
        const status = document.getElementById('statusCheckin');
        const radiusEl = document.getElementById('radiusIndicator');

        if (!selectedLocation) {
            showToast('Please select an office location first', 'error');
            status.style.display = 'block';
            status.className = 'location-box error';
            status.innerHTML = '⚠️ Select an office location first';
            return;
        }

        btn.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span> Getting GPS...';
        btn.disabled = true;
        status.style.display = 'block';
        status.className = 'location-box loading';
        status.innerHTML = '📡 Requesting GPS signal...';

        if(!navigator.geolocation) {
            status.className = 'location-box error';
            status.innerHTML = '❌ GPS not supported on this device';
            btn.innerHTML = '📍 Get My GPS Location';
            btn.disabled = false;
            showToast('GPS not supported','error');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                checkinLocation = { lat, lng };
                document.getElementById('latCheckin').value = lat;
                document.getElementById('lngCheckin').value = lng;

                const dist = calcDistance(lat, lng, selectedLocation.lat, selectedLocation.lng);
                const within = dist <= selectedLocation.radius;

                document.getElementById('withinRadius').value = within ? 'true' : 'false';

                status.className = `location-box ${within ? 'success' : 'error'}`;
                status.innerHTML = within
                    ? `✅ You're at the office! (${Math.round(dist)}m from ${selectedLocation.name})`
                    : `❌ You're ${Math.round(dist)}m away — max allowed is ${selectedLocation.radius}m`;

                radiusEl.style.display = 'flex';
                radiusEl.className = `radius-indicator ${within ? 'inside' : 'outside'}`;
                radiusEl.innerHTML = within
                    ? '✅ <span>WITHIN RADIUS — You can check in</span>'
                    : '❌ <span>OUTSIDE RADIUS — Move closer to the office</span>';

                btn.innerHTML = within ? '✅ Location Verified' : '📍 Try Again';
                if (within) {
                    btn.classList.remove('neo-btn-secondary');
                    btn.classList.add('neo-btn-green');
                    document.getElementById('submitCheckin').disabled = false;
                    document.getElementById('submitCheckin').classList.remove('pulse-glow');
                    document.getElementById('checkinHelp').textContent = '✅ You\'re within range! Click Check In Now.';
                    showToast('✅ Location verified! You\'re at the office.','success');
                } else {
                    btn.classList.remove('neo-btn-secondary');
                    btn.classList.add('neo-btn-danger');
                    document.getElementById('submitCheckin').disabled = true;
                    document.getElementById('checkinHelp').textContent = '❌ Too far from office. Move closer.';
                    showToast(`❌ ${Math.round(dist)}m away — need to be within ${selectedLocation.radius}m`,'error');
                }
                btn.disabled = false;

                initMapCheckin(lat, lng, dist);
            },
            (err) => {
                let msg = 'Cannot get location';
                if(err.code===1) msg='❌ Permission denied — allow GPS access in your browser';
                else if(err.code===2) msg='❌ GPS unavailable — try again';
                else if(err.code===3) msg='❌ GPS timed out — try again';
                status.className = 'location-box error';
                status.innerHTML = msg;
                btn.innerHTML = '📍 Try Again';
                btn.disabled = false;
                showToast(msg,'error');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    function initMapCheckin(lat, lng, dist) {
        document.getElementById('mapCheckinBox').style.display = 'block';

        if (!mapInitCheckin) {
            mapCheckin = L.map('mapCheckin').setView([lat,lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(mapCheckin);
            mapInitCheckin = true;
        }

        if (markerCheckin) mapCheckin.removeLayer(markerCheckin);
        if (circleCheckin) mapCheckin.removeLayer(circleCheckin);

        markerCheckin = L.marker([lat,lng], {draggable:true}).addTo(mapCheckin);
        markerCheckin.bindPopup(`<b>You are here</b><br>${Math.round(dist)}m from office`).openPopup();

        circleCheckin = L.circle([selectedLocation.lat, selectedLocation.lng], {
            radius: selectedLocation.radius,
            color: dist <= selectedLocation.radius ? '#00f5d4' : '#e63946',
            fillColor: dist <= selectedLocation.radius ? '#00f5d4' : '#e63946',
            fillOpacity: 0.15,
            weight: 3
        }).addTo(mapCheckin);

        L.marker([selectedLocation.lat, selectedLocation.lng], {
            icon: L.divIcon({
                className: '',
                html: '<div style="background:#fee440;border:2px solid #000;padding:4px 8px;font-weight:700;font-size:11px;white-space:nowrap;">🏢 OFFICE</div>',
                iconSize: [80, 30],
                iconAnchor: [40, 15]
            })
        }).addTo(mapCheckin);

        markerCheckin.on('dragend', (e) => {
            const p = e.target.getLatLng();
            document.getElementById('latCheckin').value = p.lat;
            document.getElementById('lngCheckin').value = p.lng;
            const newDist = calcDistance(p.lat, p.lng, selectedLocation.lat, selectedLocation.lng);
            const within = newDist <= selectedLocation.radius;
            document.getElementById('withinRadius').value = within ? 'true' : 'false';
            document.getElementById('statusCheckin').className = `location-box ${within ? 'success' : 'error'}`;
            document.getElementById('statusCheckin').innerHTML = within
                ? `✅ ${Math.round(newDist)}m from office`
                : `❌ ${Math.round(newDist)}m away`;
        });

        mapCheckin.setView([lat, lng], 15);
        setTimeout(() => mapCheckin.invalidateSize(), 200);
    }

    // --- CHECK-OUT GPS ---
    var mapCheckout, markerCheckout, circleCheckout, mapInitCheckout = false;

    function getLocationCheckout() {
        const btn = document.getElementById('btnGetLocationCheckout');
        const status = document.getElementById('statusCheckout');
        const radiusEl = document.getElementById('radiusIndicatorOut');

        btn.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span> Getting GPS...';
        btn.disabled = true;
        status.style.display = 'block';
        status.className = 'location-box loading';
        status.innerHTML = '📡 Requesting GPS signal...';

        if(!navigator.geolocation) {
            status.className = 'location-box error';
            status.innerHTML = '❌ GPS not supported';
            btn.innerHTML = '📍 Get My GPS Location';
            btn.disabled = false;
            showToast('GPS not supported','error');
            return;
        }

        var officeLat = {{ $todayAttendance && $todayAttendance->location ? $todayAttendance->location->latitude : 'null' }};
        var officeLng = {{ $todayAttendance && $todayAttendance->location ? $todayAttendance->location->longitude : 'null' }};
        var officeRadius = {{ $todayAttendance && $todayAttendance->location ? $todayAttendance->location->radius_meter : 'null' }};
        var officeName = '{{ $todayAttendance && $todayAttendance->location ? $todayAttendance->location->nama_lokasi : 'office' }}';

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                document.getElementById('latCheckout').value = lat;
                document.getElementById('lngCheckout').value = lng;

                var within = true;
                var dist = 0;

                if (officeLat && officeLng && officeRadius) {
                    dist = calcDistance(lat, lng, officeLat, officeLng);
                    within = dist <= officeRadius;
                    document.getElementById('withinRadiusOut').value = within ? 'true' : 'false';
                }

                status.className = `location-box ${within ? 'success' : 'error'}`;
                status.innerHTML = within
                    ? `✅ Location captured! (${Math.round(dist)}m from ${officeName})`
                    : `❌ ${Math.round(dist)}m from ${officeName} — max ${officeRadius}m`;

                radiusEl.style.display = 'flex';
                radiusEl.className = `radius-indicator ${within ? 'inside' : 'outside'}`;
                radiusEl.innerHTML = within
                    ? '✅ <span>WITHIN RADIUS</span>'
                    : '❌ <span>OUTSIDE RADIUS</span>';

                btn.innerHTML = within ? '✅ Location Verified' : '📍 Try Again';
                if (within) {
                    btn.classList.remove('neo-btn-secondary');
                    btn.classList.add('neo-btn-green');
                    document.getElementById('submitCheckout').disabled = false;
                    document.getElementById('submitCheckout').classList.remove('pulse-glow');
                    document.getElementById('checkoutHelp').textContent = '✅ You can check out now!';
                    showToast('✅ Location verified!','success');
                } else {
                    btn.classList.remove('neo-btn-secondary');
                    btn.classList.add('neo-btn-danger');
                    document.getElementById('submitCheckout').disabled = true;
                    document.getElementById('checkoutHelp').textContent = '❌ Too far from office';
                    showToast(`❌ ${Math.round(dist)}m away — need to be within ${officeRadius}m`,'error');
                }
                btn.disabled = false;

                initMapCheckout(lat, lng, dist, officeLat, officeLng, officeRadius, officeName);
            },
            (err) => {
                let msg = 'Cannot get location';
                if(err.code===1) msg='❌ Permission denied';
                else if(err.code===2) msg='❌ Location unavailable';
                else if(err.code===3) msg='❌ GPS timed out';
                status.className = 'location-box error';
                status.innerHTML = msg;
                btn.innerHTML = '📍 Try Again';
                btn.disabled = false;
                showToast(msg,'error');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    function initMapCheckout(lat, lng, dist, officeLat, officeLng, officeRadius, officeName) {
        document.getElementById('mapCheckoutBox').style.display = 'block';

        if (!mapInitCheckout) {
            mapCheckout = L.map('mapCheckout').setView([lat,lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(mapCheckout);
            mapInitCheckout = true;
        }

        if (markerCheckout) mapCheckout.removeLayer(markerCheckout);
        if (circleCheckout) mapCheckout.removeLayer(circleCheckout);

        markerCheckout = L.marker([lat,lng], {draggable:true}).addTo(mapCheckout);
        markerCheckout.bindPopup(`<b>You are here</b><br>${Math.round(dist)}m from office`).openPopup();

        if (officeLat && officeLng && officeRadius) {
            circleCheckout = L.circle([officeLat, officeLng], {
                radius: officeRadius,
                color: dist <= officeRadius ? '#00f5d4' : '#e63946',
                fillColor: dist <= officeRadius ? '#00f5d4' : '#e63946',
                fillOpacity: 0.15,
                weight: 3
            }).addTo(mapCheckout);

            L.marker([officeLat, officeLng], {
                icon: L.divIcon({
                    className: '',
                    html: `<div style="background:#fee440;border:2px solid #000;padding:4px 8px;font-weight:700;font-size:11px;white-space:nowrap;">🏢 ${officeName}</div>`,
                    iconSize: [80, 30],
                    iconAnchor: [40, 15]
                })
            }).addTo(mapCheckout);
        }

        mapCheckout.setView([lat, lng], 15);
        setTimeout(() => mapCheckout.invalidateSize(), 200);
    }

    // Prevent form submit if outside radius
    document.addEventListener('DOMContentLoaded', function() {
        const checkinForm = document.getElementById('checkinForm');
        if (checkinForm) {
            checkinForm.addEventListener('submit', function(e) {
                if (document.getElementById('withinRadius').value !== 'true') {
                    e.preventDefault();
                    showToast('❌ You must be within the office radius to check in', 'error');
                }
            });
        }

        const checkoutForm = document.getElementById('checkoutForm');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                if (document.getElementById('withinRadiusOut').value !== 'true') {
                    e.preventDefault();
                    showToast('❌ You must be within the office radius to check out', 'error');
                }
            });
        }
    });
</script>
@endpush
