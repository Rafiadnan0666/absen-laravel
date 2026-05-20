<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Holiday;
use App\Models\Location;
use App\Models\OvertimeRule;
use App\Models\SalaryRule;
use App\Models\Shift;
use App\Models\UserShift;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::where('user_id', auth()->id());

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status_hadir', $request->status);
        }
        if ($request->filled('month')) {
            $query->whereMonth('tanggal', $request->month);
        }

        $attendances = $query->latest('tanggal')->paginate(15)->withQueryString();

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

        $upcomingHolidays = Holiday::where('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        $stats = $this->getMonthlyStats();

        return view('employee.attendances.create', compact(
            'todayAttendance', 'userShift', 'locations',
            'upcomingHolidays', 'stats'
        ));
    }

    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function getLocationData(Location $location)
    {
        return response()->json([
            'id' => $location->id,
            'nama_lokasi' => $location->nama_lokasi,
            'latitude' => (float) $location->latitude,
            'longitude' => (float) $location->longitude,
            'radius_meter' => $location->radius_meter,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = Location::findOrFail($request->location_id);
        $distance = $this->haversineDistance(
            $request->latitude, $request->longitude,
            $location->latitude, $location->longitude
        );

        if ($distance > $location->radius_meter) {
            return redirect()->route('employee.attendances.create')
                ->with('error', 'You are outside the allowed radius for ' . $location->nama_lokasi .
                    ' (Distance: ' . round($distance) . 'm / Limit: ' . $location->radius_meter . 'm)');
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
            $tolerance = $userShift->shift->toleransi_telat_menit ?? 0;
            $graceEnd = $shiftStart->copy()->addMinutes($tolerance);

            if ($now->format('H:i:s') > $graceEnd->format('H:i:s')) {
                $status = 'late';
                $menitTelat = $now->diffInMinutes($shiftStart);
            }
        }

        $isHoliday = Holiday::where('tanggal', today())->exists();

        $attendance = Attendance::create([
            'user_id' => auth()->id(),
            'tanggal' => today(),
            'check_in' => $now->format('H:i:s'),
            'status_hadir' => $isHoliday ? 'holiday' : $status,
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
            'jarak_meter' => round($distance),
            'device' => 'web',
        ]);

        $distanceMsg = round($distance) . 'm from office';

        return redirect()->route('employee.attendances.create')
            ->with('success', "Check-in successful! ({$distanceMsg}) ✅");
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
                $distance = $this->haversineDistance(
                    $request->latitude, $request->longitude,
                    $location->latitude, $location->longitude
                );
                if ($distance > $location->radius_meter) {
                    return redirect()->route('employee.attendances.create')
                        ->with('error', 'You must be at ' . $location->nama_lokasi .
                            ' to check out (Distance: ' . round($distance) . 'm / Limit: ' . $location->radius_meter . 'm)');
                }
            }
        }

        $now = Carbon::now();
        $userShift = UserShift::where('user_id', auth()->id())
            ->whereDate('tanggal_shift', today())
            ->with('shift')
            ->first();

        $menitPulangCepat = 0;
        $isOvertime = false;

        if ($userShift && $userShift->shift) {
            $shiftEnd = Carbon::parse($userShift->shift->jam_pulang);
            if ($now->format('H:i:s') < $shiftEnd->format('H:i:s')) {
                $menitPulangCepat = $now->diffInMinutes($shiftEnd);
            } elseif ($now->format('H:i:s') > $shiftEnd->format('H:i:s')) {
                $isOvertime = true;
            }
        }

        $checkIn = Carbon::parse($attendance->check_in);
        $totalMinutes = $checkIn->diffInMinutes($now);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $seconds = $totalMinutes * 60 - $hours * 3600 - $minutes * 60;
        $jamKerja = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $jamLembur = null;
        if ($isOvertime) {
            $overtimeRules = OvertimeRule::orderBy('minimal_jam')->get();
            $overtimeMinutes = $now->diffInMinutes(Carbon::parse($userShift->shift->jam_pulang));
            if ($overtimeMinutes > 0) {
                $jamLembur = sprintf('%02d:%02d:%02d', floor($overtimeMinutes / 60), $overtimeMinutes % 60, 0);
            }
        }

        // Calculate late penalty from SalaryRule
        $latePenalty = 0;
        if ($attendance->menit_telat > 0) {
            $salaryRule = SalaryRule::where('tipe_gaji', auth()->user()->tipe_gaji)->first();
            if ($salaryRule && $salaryRule->penalti_telat_per_menit > 0) {
                $latePenalty = $attendance->menit_telat * $salaryRule->penalti_telat_per_menit;
            }
        }

        $attendance->update([
            'check_out' => $now->format('H:i:s'),
            'jam_kerja' => $jamKerja,
            'jam_lembur' => $jamLembur,
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

        $overtimeMsg = $jamLembur ? " Overtime: {$jamLembur}" : '';
        $penaltyMsg = $latePenalty > 0 ? " Late penalty: Rp " . number_format($latePenalty, 0, ',', '.') : '';

        return redirect()->route('employee.attendances.create')
            ->with('success', "Check-out successful! Work hours: {$jamKerja}{$overtimeMsg}{$penaltyMsg} ✅");
    }

    public function logs()
    {
        $logs = AttendanceLog::where('user_id', auth()->id())
            ->latest('waktu_log')
            ->paginate(20);

        return view('employee.attendances.logs', compact('logs'));
    }

    private function getMonthlyStats()
    {
        $userId = auth()->id();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        $totalDays = Attendance::where('user_id', $userId)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->count();

        $presentDays = Attendance::where('user_id', $userId)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->whereIn('status_hadir', ['present', 'late'])
            ->count();

        $lateDays = Attendance::where('user_id', $userId)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('status_hadir', 'late')
            ->count();

        $totalWorkMinutes = Attendance::where('user_id', $userId)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->whereNotNull('jam_kerja')
            ->get()
            ->sum(function ($a) {
                if (!$a->jam_kerja) return 0;
                return $a->jam_kerja->hour * 60 + $a->jam_kerja->minute;
            });

        $totalOvertimeMinutes = Attendance::where('user_id', $userId)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->whereNotNull('jam_lembur')
            ->get()
            ->sum(function ($a) {
                if (!$a->jam_lembur) return 0;
                return $a->jam_lembur->hour * 60 + $a->jam_lembur->minute;
            });

        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dayAttendance = Attendance::where('user_id', $userId)
                ->whereDate('tanggal', $day)
                ->first();
            $jamKerja = $dayAttendance?->jam_kerja;
            $weeklyData[] = [
                'date' => $day->format('D'),
                'status' => $dayAttendance ? $dayAttendance->status_hadir : 'none',
                'hours' => $jamKerja ? $jamKerja->format('H:i') : '-',
                'hours_numeric' => $jamKerja ? round($jamKerja->hour + $jamKerja->minute / 60, 1) : 0,
            ];
        }

        return [
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'late_days' => $lateDays,
            'absent_days' => $totalDays - $presentDays,
            'attendance_rate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0,
            'total_work_hours' => floor($totalWorkMinutes / 60) . 'h ' . ($totalWorkMinutes % 60) . 'm',
            'total_overtime' => floor($totalOvertimeMinutes / 60) . 'h ' . ($totalOvertimeMinutes % 60) . 'm',
            'weekly' => $weeklyData,
        ];
    }
}
