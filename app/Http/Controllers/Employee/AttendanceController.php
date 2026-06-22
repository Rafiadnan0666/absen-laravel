<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Location;
use App\Models\Shift;
use App\Models\UserShift;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function index()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->latest('tanggal')
            ->paginate(15);

        return view('employee.attendances.index', compact('attendances'));
    }

    public function create()
    {
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->first();

        $userShift = UserShift::where('user_id', auth()->id())
            ->whereDate('tanggal_shift', today())
            ->with('shift')
            ->first();

        $locations = Location::all();
        $locationsJson = $locations->map(fn($loc) => [
            'id' => $loc->id,
            'nama_lokasi' => $loc->nama_lokasi,
            'latitude' => (float) $loc->latitude,
            'longitude' => (float) $loc->longitude,
            'radius_meter' => $loc->radius_meter ?? 100,
        ]);

        $checkinLocation = null;
        if ($todayAttendance && $todayAttendance->location_id) {
            $checkinLocation = $todayAttendance->location;
        }

        return view('employee.attendances.create', compact(
            'todayAttendance', 'userShift', 'locations', 'locationsJson', 'checkinLocation'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = Location::findOrFail($request->location_id);
        $radius = $location->radius_meter ?? 100;
        $distance = $this->calculateDistance(
            $request->latitude, $request->longitude,
            $location->latitude, $location->longitude
        );

        if ($distance > $radius) {
            return redirect()->route('employee.attendances.create')
                ->with('error', 'You are too far from the selected location (' . round($distance) . 'm, max allowed: ' . $radius . 'm). Please move closer to check in.');
        }

        $now = Carbon::now();
        $userShift = UserShift::where('user_id', auth()->id())
            ->whereDate('tanggal_shift', today())
            ->with('shift')
            ->first();

        $status = 'present';
        $menitTelat = 0;

        if ($userShift && $userShift->shift) {
            $shiftStart = Carbon::parse($userShift->shift->jam_masuk);
            if ($now->format('H:i:s') > $shiftStart->format('H:i:s')) {
                $status = 'late';
                $menitTelat = $now->diffInMinutes($shiftStart);
            }
        }

        $attendance = Attendance::create([
            'user_id' => auth()->id(),
            'tanggal' => today(),
            'check_in' => $now->format('H:i:s'),
            'status_hadir' => $status,
            'menit_telat' => $menitTelat,
            'location_id' => $request->location_id,
            'face_verified' => false,
        ]);

        AttendanceLog::create([
            'user_id' => auth()->id(),
            'tipe_log' => 'check_in',
            'waktu_log' => $now,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'device' => 'web',
        ]);

        return redirect()->route('employee.attendances.create')
            ->with('success', 'Check-in successful!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('tanggal', today())
            ->whereNull('check_out')
            ->first();

        if (!$attendance) {
            return redirect()->route('employee.attendances.create')
                ->with('error', 'No check-in record found for today.');
        }

        if ($attendance->location_id) {
            $location = Location::find($attendance->location_id);
            if ($location) {
                $radius = $location->radius_meter ?? 100;
                $distance = $this->calculateDistance(
                    $request->latitude, $request->longitude,
                    $location->latitude, $location->longitude
                );
                if ($distance > $radius) {
                    return redirect()->route('employee.attendances.create')
                        ->with('error', 'You are too far from the check-in location (' . round($distance) . 'm, max allowed: ' . $radius . 'm). Please move closer to check out.');
                }
            }
        }

        $now = Carbon::now();
        $userShift = UserShift::where('user_id', auth()->id())
            ->whereDate('tanggal_shift', today())
            ->with('shift')
            ->first();

        $menitPulangCepat = 0;
        if ($userShift && $userShift->shift) {
            $shiftEnd = Carbon::parse($userShift->shift->jam_pulang);
            if ($now->format('H:i:s') < $shiftEnd->format('H:i:s')) {
                $menitPulangCepat = $now->diffInMinutes($shiftEnd);
            }
        }

        $checkIn = Carbon::parse($attendance->check_in);
        $jamKerja = $checkIn->diff($now)->format('%H:%I:%S');

        $attendance->update([
            'check_out' => $now->format('H:i:s'),
            'jam_kerja' => $jamKerja,
            'menit_pulang_cepat' => $menitPulangCepat,
        ]);

        AttendanceLog::create([
            'user_id' => auth()->id(),
            'tipe_log' => 'check_out',
            'waktu_log' => $now,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'device' => 'web',
        ]);

        return redirect()->route('employee.attendances.create')
            ->with('success', 'Check-out successful!');
    }

    public function logs()
    {
        $logs = AttendanceLog::where('user_id', auth()->id())
            ->latest('waktu_log')
            ->paginate(20);

        return view('employee.attendances.logs', compact('logs'));
    }
}
