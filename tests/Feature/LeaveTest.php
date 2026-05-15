<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_view_leave_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('employee.leaves.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_request_leave(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employee.leaves.store'), [
            'jenis_cuti' => 'sakit',
            'tanggal_mulai' => now()->addDays(2)->toDateString(),
            'tanggal_akhir' => now()->addDays(4)->toDateString(),
            'alasan' => 'Sakit flu dan perlu istirahat',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'jenis_cuti' => 'sakit',
        ]);
    }

    public function test_employee_cannot_request_leave_with_past_date(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employee.leaves.store'), [
            'jenis_cuti' => 'sakit',
            'tanggal_mulai' => now()->subDay()->toDateString(),
            'tanggal_akhir' => now()->subDay()->toDateString(),
            'alasan' => 'Sakit',
        ]);

        $response->assertSessionHasErrors('tanggal_mulai');
    }

    public function test_employee_can_view_their_leave_history(): void
    {
        $user = User::factory()->create();
        Leave::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('employee.leaves.index'));

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_leave(): void
    {
        $response = $this->get(route('employee.leaves.index'));

        $response->assertRedirect(route('login'));
    }
}