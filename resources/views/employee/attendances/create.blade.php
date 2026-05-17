@extends('layouts.employee')

@section('page-title', 'Check In/Out')

@push('styles')
<style>
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    .toast { padding: 14px 20px; border: 3px solid #000; font-weight: 700; font-size: 14px; margin-bottom: 10px; box-shadow: 4px 4px 0 #000; transform: translateX(400px); transition: transform 0.3s ease; }
    .toast.show { transform: translateX(0); }
    .toast-success { background: #10b981; color: white; }
    .toast-error { background: #ef4444; color: white; }
    .location-box { padding: 16px; border: 3px solid #000; margin-top: 12px; font-size: 14px; }
    .location-box.success { background: #d1fae5; }
    .location-box.error { background: #fee2e2; }
    .location-box.loading { background: #e0e7ff; }
    .map-frame { height: 220px; margin-top: 12px; border: 3px solid #000; overflow: hidden; }
</style>
@endpush

@section('content')
    <h1 class="neo-section-title">Check In / Check Out</h1>

    <div id="toastContainer" class="toast-container"></div>

    @if(session('success'))
    <div class="neo-alert-success mb-6">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="neo-alert-danger mb-6">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="neo-card p-6">
            <h3 class="neo-label text-lg mb-4">Check In</h3>
            
            @if($todayAttendance && $todayAttendance->check_in)
                <div class="neo-card-green p-4">
                    <p class="font-bold">Checked in at {{ $todayAttendance->check_in }}</p>
                    <p class="text-sm mt-1">Status: <span class="font-bold">{{ strtoupper($todayAttendance->status_hadir) }}</span></p>
                    @if($todayAttendance->menit_telat > 0)
                        <p class="text-sm text-neo-red mt-1">Late: {{ $todayAttendance->menit_telat }} minutes</p>
                    @endif
                </div>
            @else
                <form action="{{ route('employee.attendances.store') }}" method="POST">
                    @csrf
                    <div class="neo-form-group">
                        <label class="neo-label">Office Location</label>
                        <select name="location_id" class="neo-select" required>
                            <option value="">Select office...</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="button" id="btnGetLocationCheckin" class="neo-btn-secondary w-full mb-3" onclick="getLocationCheckin()">
                        Get My GPS Location
                    </button>
                    
                    <div id="statusCheckin" style="display:none;" class="location-box mb-3"></div>
                    <div id="mapCheckinBox" class="map-frame" style="display:none;">
                        <div id="mapCheckin" style="width:100%;height:100%;"></div>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latCheckin" value="">
                    <input type="hidden" name="longitude" id="lngCheckin" value="">
                    
                    <button type="submit" class="neo-btn-green w-full text-lg py-4">
                        Check In Now
                    </button>
                </form>
            @endif
        </div>

        <div class="neo-card p-6">
            <h3 class="neo-label text-lg mb-4">Check Out</h3>
            
            @if($todayAttendance && $todayAttendance->check_out)
                <div class="neo-card-green p-4">
                    <p class="font-bold">Checked out at {{ $todayAttendance->check_out }}</p>
                    <p class="text-sm mt-1">Work Hours: {{ $todayAttendance->jam_kerja ?? '-' }}</p>
                    @if($todayAttendance->jam_lembur)
                        <p class="text-sm text-neo-blue mt-1">Overtime: {{ $todayAttendance->jam_lembur }}</p>
                    @endif
                </div>
            @elseif($todayAttendance && $todayAttendance->check_in)
                <form action="{{ route('employee.attendances.checkout') }}" method="POST">
                    @csrf
                    <div class="neo-card-purple p-4 mb-4">
                        <p class="font-bold">Checked in at: {{ $todayAttendance->check_in }}</p>
                        <p class="text-sm">Status: {{ strtoupper($todayAttendance->status_hadir) }}</p>
                    </div>
                    
                    <button type="button" id="btnGetLocationCheckout" class="neo-btn-secondary w-full mb-3" onclick="getLocationCheckout()">
                        Get My GPS Location
                    </button>
                    
                    <div id="statusCheckout" style="display:none;" class="location-box mb-3"></div>
                    <div id="mapCheckoutBox" class="map-frame" style="display:none;">
                        <div id="mapCheckout" style="width:100%;height:100%;"></div>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latCheckout" value="">
                    <input type="hidden" name="longitude" id="lngCheckout" value="">
                    
                    <button type="submit" class="neo-btn-pink w-full text-lg py-4">
                        Check Out Now
                    </button>
                </form>
            @else
                <div class="neo-card p-4">
                    <p class="font-bold">Please check in first</p>
                </div>
            @endif
        </div>
    </div>

    @if($userShift)
    <div class="neo-card p-6 mb-6">
        <h3 class="neo-label text-lg mb-4">Today's Shift</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="neo-card text-center">
                <p class="neo-label mb-1">Shift</p>
                <p class="font-bold">{{ $userShift->shift->nama_shift }}</p>
            </div>
            <div class="neo-card text-center">
                <p class="neo-label mb-1">Start</p>
                <p class="font-bold">{{ $userShift->shift->jam_masuk }}</p>
            </div>
            <div class="neo-card text-center">
                <p class="neo-label mb-1">End</p>
                <p class="font-bold">{{ $userShift->shift->jam_pulang }}</p>
            </div>
            <div class="neo-card text-center">
                <p class="neo-label mb-1">Tolerance</p>
                <p class="font-bold">{{ $userShift->shift->toleransi_telat_menit }} min</p>
            </div>
        </div>
    </div>
    @endif

    @if($todayAttendance)
    <div class="neo-card p-6">
        <h3 class="neo-label text-lg mb-4">Today's Attendance</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="neo-card"><p class="neo-label mb-1">Status</p><p class="font-bold">{{ strtoupper($todayAttendance->status_hadir) }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Check In</p><p class="font-bold">{{ $todayAttendance->check_in ?? '-' }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Check Out</p><p class="font-bold">{{ $todayAttendance->check_out ?? '-' }}</p></div>
            <div class="neo-card"><p class="neo-label mb-1">Work Hours</p><p class="font-bold">{{ $todayAttendance->jam_kerja ?? '-' }}</p></div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
    function showToast(msg, type) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = msg;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(()=>toast.remove(),300); }, 3000);
    }

    var mapCheckin, markerCheckin, mapInitCheckin = false;
    
    function getLocationCheckin() {
        const btn = document.getElementById('btnGetLocationCheckin');
        const status = document.getElementById('statusCheckin');
        
        btn.innerHTML = 'Getting...';
        btn.disabled = true;
        status.style.display = 'block';
        status.className = 'location-box loading';
        status.innerHTML = 'Requesting GPS...';
        
        if(!navigator.geolocation) {
            status.className = 'location-box error';
            status.innerHTML = 'GPS not supported';
            btn.innerHTML = 'Get My GPS Location';
            btn.disabled = false;
            showToast('GPS not supported','error');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                document.getElementById('latCheckin').value = lat;
                document.getElementById('lngCheckin').value = lng;
                status.className = 'location-box success';
                status.innerHTML = `Captured! (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
                btn.innerHTML = 'Location Captured';
                btn.classList.remove('neo-btn-secondary');
                btn.classList.add('neo-btn-green');
                initMapCheckin(lat, lng);
                showToast('GPS Location captured!','success');
            },
            (err) => {
                let msg = 'Cannot get location';
                if(err.code===1) msg='Permission denied';
                else if(err.code===2) msg='Location unavailable';
                status.className = 'location-box error';
                status.innerHTML = msg;
                btn.innerHTML = 'Get My GPS Location';
                btn.disabled = false;
                showToast(msg,'error');
            }
        );
    }
    
    function initMapCheckin(lat, lng) {
        if(mapInitCheckin) return;
        document.getElementById('mapCheckinBox').style.display = 'block';
        mapCheckin = L.map('mapCheckin').setView([lat,lng],16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapCheckin);
        markerCheckin = L.marker([lat,lng],{draggable:true}).addTo(mapCheckin);
        mapCheckin.on('click', (e) => {
            markerCheckin.setLatLng(e.latlng);
            document.getElementById('latCheckin').value = e.latlng.lat;
            document.getElementById('lngCheckin').value = e.latlng.lng;
        });
        markerCheckin.on('dragend', (e) => {
            document.getElementById('latCheckin').value = e.target.getLatLng().lat;
            document.getElementById('lngCheckin').value = e.target.getLatLng().lng;
        });
        mapInitCheckin = true;
        setTimeout(()=>mapCheckin.invalidateSize(),100);
    }

    var mapCheckout, markerCheckout, mapInitCheckout = false;
    
    function getLocationCheckout() {
        const btn = document.getElementById('btnGetLocationCheckout');
        const status = document.getElementById('statusCheckout');
        
        btn.innerHTML = 'Getting...';
        btn.disabled = true;
        status.style.display = 'block';
        status.className = 'location-box loading';
        status.innerHTML = 'Requesting GPS...';
        
        if(!navigator.geolocation) {
            status.className = 'location-box error';
            status.innerHTML = 'GPS not supported';
            btn.innerHTML = 'Get My GPS Location';
            btn.disabled = false;
            showToast('GPS not supported','error');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude, lng = pos.coords.longitude;
                document.getElementById('latCheckout').value = lat;
                document.getElementById('lngCheckout').value = lng;
                status.className = 'location-box success';
                status.innerHTML = `Captured! (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
                btn.innerHTML = 'Location Captured';
                btn.classList.remove('neo-btn-secondary');
                btn.classList.add('neo-btn-green');
                initMapCheckout(lat, lng);
                showToast('GPS Location captured!','success');
            },
            (err) => {
                let msg = 'Cannot get location';
                if(err.code===1) msg='Permission denied';
                else if(err.code===2) msg='Location unavailable';
                status.className = 'location-box error';
                status.innerHTML = msg;
                btn.innerHTML = 'Get My GPS Location';
                btn.disabled = false;
                showToast(msg,'error');
            }
        );
    }
    
    function initMapCheckout(lat, lng) {
        if(mapInitCheckout) return;
        document.getElementById('mapCheckoutBox').style.display = 'block';
        mapCheckout = L.map('mapCheckout').setView([lat,lng],16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapCheckout);
        markerCheckout = L.marker([lat,lng],{draggable:true}).addTo(mapCheckout);
        mapCheckout.on('click', (e) => {
            markerCheckout.setLatLng(e.latlng);
            document.getElementById('latCheckout').value = e.latlng.lat;
            document.getElementById('lngCheckout').value = e.latlng.lng;
        });
        markerCheckout.on('dragend', (e) => {
            document.getElementById('latCheckout').value = e.target.getLatLng().lat;
            document.getElementById('lngCheckout').value = e.target.getLatLng().lng;
        });
        mapInitCheckout = true;
        setTimeout(()=>mapCheckout.invalidateSize(),100);
    }
</script>
@endpush