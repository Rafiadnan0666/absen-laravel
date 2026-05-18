<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_attendances(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/attendances');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'current_page']);
    }

    public function test_can_filter_attendances_by_status(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        Attendance::factory()->create(['user_id' => $admin->id, 'status_hadir' => 'present']);
        Attendance::factory()->create(['user_id' => $admin->id, 'status_hadir' => 'absent']);

        $response = $this->actingAs($admin)->getJson('/api/attendances?status=present');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_can_create_attendance(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/attendances', [
            'user_id' => $user->id,
            'tanggal' => '2026-05-18',
            'check_in' => '08:00',
            'status_hadir' => 'present',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'user_id', 'tanggal', 'status_hadir']);
    }

    public function test_cannot_create_attendance_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/attendances', [
            'user_id' => $user->id,
            'tanggal' => 'not-a-date',
            'status_hadir' => 'invalid',
        ]);

        $response->assertStatus(422);
    }

    public function test_can_show_attendance(): void
    {
        $user = User::factory()->create();
        $attendance = Attendance::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/attendances/{$attendance->id}");

        $response->assertStatus(200)
            ->assertJsonPath('id', $attendance->id);
    }
}
