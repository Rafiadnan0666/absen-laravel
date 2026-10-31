<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    private const OFFICE_LATITUDE = -6.2088;

    private const OFFICE_LONGITUDE = 106.8456;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    private function createOffice(int $radiusMeter = 100): Location
    {
        return Location::create([
            'nama_lokasi' => 'Kantor Pusat',
            'latitude' => self::OFFICE_LATITUDE,
            'longitude' => self::OFFICE_LONGITUDE,
            'radius_meter' => $radiusMeter,
        ]);
    }

    public function test_employee_can_view_attendance_page(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)
            ->get(route('employee.attendances.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_view_check_in_page(): void
    {
        $user = $this->createEmployee();
        $this->createOffice();

        $response = $this->actingAs($user)
            ->get(route('employee.attendances.create'));

        $response->assertStatus(200);
    }

    public function test_employee_can_check_in_inside_geofence(): void
    {
        $user = $this->createEmployee();
        $location = $this->createOffice(100);

        $response = $this->actingAs($user)->post(route('employee.attendances.store'), [
            'location_id' => $location->id,
            'latitude' => self::OFFICE_LATITUDE,
            'longitude' => self::OFFICE_LONGITUDE,
        ]);

        $response->assertRedirect(route('employee.attendances.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'location_id' => $location->id,
        ]);

        $this->assertDatabaseHas('attendance_logs', [
            'user_id' => $user->id,
            'tipe_log' => 'check_in',
            'jarak_meter' => 0,
        ]);
    }

    public function test_employee_cannot_check_in_outside_geofence(): void
    {
        $user = $this->createEmployee();
        $location = $this->createOffice(100);

        $response = $this->actingAs($user)->post(route('employee.attendances.store'), [
            'location_id' => $location->id,
            'latitude' => -6.3000,
            'longitude' => 106.9000,
        ]);

        $response->assertRedirect(route('employee.attendances.create'));
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('attendances', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseMissing('attendance_logs', [
            'user_id' => $user->id,
        ]);
    }

    public function test_check_in_requires_location_and_coordinates(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)->post(route('employee.attendances.store'), []);

        $response->assertSessionHasErrors(['location_id', 'latitude', 'longitude']);
        $this->assertSame(0, Attendance::count());
        $this->assertSame(0, AttendanceLog::count());
    }

    public function test_employee_can_view_their_attendance_history(): void
    {
        $user = $this->createEmployee();
        Attendance::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('employee.attendances.index'));

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_attendance(): void
    {
        $response = $this->get(route('employee.attendances.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_all_attendances(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->get(route('admin.attendances.index'));

        $response->assertStatus(200);
    }

    public function test_hr_can_view_all_attendances(): void
    {
        $hr = $this->createHR();

        $response = $this->actingAs($hr)
            ->get(route('hr.attendances.index'));

        $response->assertStatus(200);
    }

    public function test_employee_cannot_access_admin_attendance_page(): void
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($employee)
            ->get(route('admin.attendances.index'));

        $response->assertRedirect(route('dashboard'));
    }
}
