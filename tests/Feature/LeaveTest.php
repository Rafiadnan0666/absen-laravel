<?php

namespace Tests\Feature;

use App\Models\Leave;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JobTitleSeeder::class);
        $this->seed(\Database\Seeders\PermissionSeeder::class);
    }

    private function createEmployee(): User
    {
        $role = Role::where('nama_role', 'employee')->first();
        return User::factory()->create(['role_id' => $role->id]);
    }

    private function createHR(): User
    {
        $role = Role::where('nama_role', 'hr')->first();
        return User::factory()->create(['role_id' => $role->id]);
    }

    private function createAdmin(): User
    {
        $role = Role::where('nama_role', 'admin')->first();
        return User::factory()->create(['role_id' => $role->id]);
    }

    public function test_employee_can_view_leave_page(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)
            ->get(route('employee.leaves.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_request_leave(): void
    {
        $user = $this->createEmployee();

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
            'status_pengajuan' => 'pending',
        ]);
    }

    public function test_employee_cannot_request_leave_with_past_date(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)->post(route('employee.leaves.store'), [
            'jenis_cuti' => 'sakit',
            'tanggal_mulai' => now()->subDay()->toDateString(),
            'tanggal_selesai' => now()->subDay()->toDateString(),
            'alasan' => 'Sakit',
        ]);

        $response->assertSessionHasErrors('tanggal_mulai');
    }

    public function test_employee_can_view_their_leave_history(): void
    {
        $user = $this->createEmployee();
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

    public function test_hr_can_approve_leave(): void
    {
        $employee = $this->createEmployee();
        $hr = $this->createHR();
        $leave = Leave::factory()->create([
            'user_id' => $employee->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($hr)->post(route('hr.leaves.approve', $leave));

        $response->assertRedirect();
        $leave->refresh();
        $this->assertEquals('approved', $leave->status_pengajuan);
    }

    public function test_hr_can_reject_leave(): void
    {
        $employee = $this->createEmployee();
        $hr = $this->createHR();
        $leave = Leave::factory()->create([
            'user_id' => $employee->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($hr)->post(route('hr.leaves.reject', $leave));

        $response->assertRedirect();
        $leave->refresh();
        $this->assertEquals('rejected', $leave->status_pengajuan);
    }

    public function test_employee_cannot_approve_leave(): void
    {
        $employee = $this->createEmployee();
        $leave = Leave::factory()->create([
            'user_id' => $employee->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($employee)->post(route('hr.leaves.approve', $leave));

        $response->assertStatus(302);
        $leave->refresh();
        $this->assertEquals('pending', $leave->status_pengajuan);
    }

    public function test_employee_cannot_reject_leave(): void
    {
        $employee = $this->createEmployee();
        $leave = Leave::factory()->create([
            'user_id' => $employee->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($employee)->post(route('hr.leaves.reject', $leave));

        $response->assertStatus(302);
        $leave->refresh();
        $this->assertEquals('pending', $leave->status_pengajuan);
    }

    public function test_employee_cannot_access_hr_leave_page(): void
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($employee)->get(route('hr.leaves.index'));

        $response->assertStatus(302);
    }

    public function test_employee_cannot_access_other_employee_leave_data(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();
        $leave = Leave::factory()->create([
            'user_id' => $employee2->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($employee1)->get(route('employee.leaves.show', $leave));

        $response->assertStatus(403);
    }

    public function test_hr_can_view_all_pending_leaves(): void
    {
        $hr = $this->createHR();
        $employee = $this->createEmployee();
        Leave::factory()->count(3)->create([
            'user_id' => $employee->id,
            'status_pengajuan' => 'pending',
        ]);

        $response = $this->actingAs($hr)->get(route('hr.leaves.index'));

        $response->assertStatus(200);
    }
}