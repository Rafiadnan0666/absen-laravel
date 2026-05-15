<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_view_attendance_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('employee.attendances.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_create_check_in(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employee.attendances.store'), [
            'type' => 'check_in',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
        ]);

        $response->assertRedirect();
    }

    public function test_employee_can_view_their_attendance_history(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('employee.attendances.index'));

        $response->assertStatus(200);
        $response->assertSee('attendance');
    }

    public function test_unauthenticated_user_cannot_access_attendance(): void
    {
        $response = $this->get(route('employee.attendances.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_all_attendances(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.attendances.index'));

        $response->assertStatus(200);
    }
}