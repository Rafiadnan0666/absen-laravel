<?php

namespace App\Http\Controllers\Api\V1;

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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Attendance::where('user_id', $user->id);

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

        return response()->json($attendances);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = $request->user();
        $location = Location::findOrFail($request->location_id);

        $distance = $this->haversineDistance(
            $request->latitude, $request->longitude,
            $location->latitude, $location->longitude
        );

        if ($distance > $location->radius_meter) {
            return response()->json([
                'message' => 'You are outside the allowed radius for ' . $location->nama_lokasi .
                    ' (Distance: ' . round($distance) . 'm / Limit: ' . $location->radius_meter . 'm)'
            ], 422);
        }

        $now = Carbon::now();
        $today = today();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Already checked in today',
                'attendance' => $existing
            ], 409);
        }

        $userShift = UserShift::where('user_id', $user->id)
            ->whereDate('tanggal_shift', $today)
            ->with('shift')
            ->first();

        $status = 'present';
        $menitTelat = 0;

        if ($userShift && $userShift->shift) {
            $shift = $userShift->shift;
            $isOvernight = $this->isOvernightShift($shift->jam_masuk, $shift->jam_pulang);
            $shiftStart = $this->getShiftStartDateTime($shift->jam_masuk, $today, $isOvernight);
            $tolerance = $shift->toleransi_telat_menit ?? 0;
            $graceEnd = $shiftStart->copy()->addMinutes($tolerance);

            if ($now->gt($graceEnd)) {
                $status = 'late';
                $menitTelat = $now->diffInMinutes($shiftStart);
            }
        }

        $isHoliday = Holiday::where('tanggal', $today)->exists();

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'check_in' => $now->format('H:i:s'),
            'status_hadir' => $isHoliday ? 'holiday' : $status,
            'menit_telat' => $menitTelat,
            'location_id' => $request->location_id,
            'face_verified' => false,
        ]);

        AttendanceLog::create([
            'user_id' => $user->id,
            'tipe_log' => 'check_in',
            'waktu_log' => $now,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jarak_meter' => round($distance),
            'device' => 'mobile',
        ]);

        return response()->json([
            'message' => 'Check-in successful!',
            'attendance' => $attendance,
            'distance' => round($distance) . 'm from office'
        ], 201);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = $request->user();
        $today = today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->whereNull('check_out')
            ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'No check-in record found for today.'
            ], 404);
        }

        if ($attendance->location_id) {
            $location = Location::find($attendance->location_id);
            if ($location) {
                $distance = $this->haversineDistance(
                    $request->latitude, $request->longitude,
                    $location->latitude, $location->longitude
                );
                if ($distance > $location->radius_meter) {
                    return response()->json([
                        'message' => 'You must be at ' . $location->nama_lokasi .
                            ' to check out (Distance: ' . round($distance) . 'm / Limit: ' . $location->radius_meter . 'm)'
                    ], 422);
                }
            }
        }

        $now = Carbon::now();
        $userShift = UserShift::where('user_id', $user->id)
            ->whereDate('tanggal_shift', $today)
            ->with('shift')
            ->first();

        $menitPulangCepat = 0;
        $isOvertime = false;
        $jamLembur = null;

        if ($userShift && $userShift->shift) {
            $shift = $userShift->shift;
            $isOvernight = $this->isOvernightShift($shift->jam_masuk, $shift->jam_pulang);
            $shiftEnd = $this->getShiftEndDateTime($shift->jam_masuk, $shift->jam_pulang, $today, $isOvernight);

            if ($now->lt($shiftEnd)) {
                $menitPulangCepat = $now->diffInMinutes($shiftEnd);
            } elseif ($now->gt($shiftEnd)) {
                $isOvertime = true;
            }
        }

        $checkIn = Carbon::parse($attendance->tanggal->format('Y-m-d') . ' ' . $attendance->check_in->format('H:i:s'));
        $totalMinutes = $checkIn->diffInMinutes($now);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $seconds = $totalMinutes * 60 - $hours * 3600 - $minutes * 60;
        $jamKerja = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        if ($isOvertime && $userShift && $userShift->shift) {
            $shift = $userShift->shift;
            $isOvernight = $this->isOvernightShift($shift->jam_masuk, $shift->jam_pulang);
            $shiftEnd = $this->getShiftEndDateTime($shift->jam_masuk, $shift->jam_pulang, $today, $isOvernight);
            $overtimeMinutes = $now->diffInMinutes($shiftEnd);
            if ($overtimeMinutes > 0) {
                $jamLembur = sprintf('%02d:%02d:%02d', floor($overtimeMinutes / 60), $overtimeMinutes % 60, 0);
            }
        }

        $latePenalty = 0;
        if ($attendance->menit_telat > 0) {
            $salaryRule = SalaryRule::where('tipe_gaji', $user->tipe_gaji)->first();
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
            'user_id' => $user->id,
            'tipe_log' => 'check_out',
            'waktu_log' => $now,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'device' => 'mobile',
        ]);

        return response()->json([
            'message' => 'Check-out successful!',
            'attendance' => $attendance->fresh(),
            'work_hours' => $jamKerja,
            'overtime' => $jamLembur,
            'late_penalty' => $latePenalty > 0 ? $latePenalty : null
        ]);
    }

    public function show(Request $request, Attendance $attendance)
    {
        $user = $request->user();

        // Employee routes should always enforce ownership
        if ($request->routeIs('api.employee.*')) {
            if ($user->id !== $attendance->user_id) {
                abort(403);
            }
        } elseif ($user->id !== $attendance->user_id && !$user->role->hasPermission('attendances', 'view')) {
            // Admin routes check permissions
            abort(403);
        }

        return response()->json($attendance->load('location'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $user = $request->user();

        if (!$user->role->hasPermission('attendances', 'update')) {
            abort(403);
        }

        $validated = $request->validate([
            'check_in' => 'sometimes|date_format:H:i:s',
            'check_out' => 'sometimes|date_format:H:i:s|after:check_in',
            'status_hadir' => 'sometimes|in:present,late,absent,holiday',
            'menit_telat' => 'sometimes|integer|min:0',
            'menit_pulang_cepat' => 'sometimes|integer|min:0',
            'jam_lembur' => 'sometimes|date_format:H:i:s',
            'location_id' => 'sometimes|exists:locations,id',
        ]);

        $attendance->update($validated);

        return response()->json($attendance);
    }

    public function destroy(Request $request, Attendance $attendance)
    {
        $user = $request->user();

        if (!$user->role->hasPermission('attendances', 'delete')) {
            abort(403);
        }

        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted']);
    }

    public function export(Request $request)
    {
        $user = $request->user();

        if (!$user->role->hasPermission('attendances', 'view')) {
            abort(403);
        }

        $query = Attendance::with('user', 'location');

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('status')) {
            $query->where('status_hadir', $request->status);
        }

        $attendances = $query->latest('tanggal')->get();

        return response()->json($attendances);
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

    private function isOvernightShift(string $jamMasuk, string $jamPulang): bool
    {
        return $jamPulang < $jamMasuk;
    }

    private function getShiftStartDateTime(string $jamMasuk, \Carbon\Carbon $tanggalShift, bool $isOvernight): \Carbon\Carbon
    {
        $start = \Carbon\Carbon::parse($tanggalShift->format('Y-m-d') . ' ' . $jamMasuk);
        if ($isOvernight) {
            // For overnight shifts, the shift starts on the previous day
            $start->subDay();
        }
        return $start;
    }

    private function getShiftEndDateTime(string $jamMasuk, string $jamPulang, \Carbon\Carbon $tanggalShift, bool $isOvernight): \Carbon\Carbon
    {
        $end = \Carbon\Carbon::parse($tanggalShift->format('Y-m-d') . ' ' . $jamPulang);
        if ($isOvernight) {
            // For overnight shifts, the shift ends on the next day
            $end->addDay();
        }
        return $end;
    }
}