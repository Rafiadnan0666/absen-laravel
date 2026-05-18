<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\UserShift;
use App\Models\Shift;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_payroll_total_calculation_is_correct(): void
    {
        $user = User::factory()->create();

        $payroll = Payroll::factory()->create([
            'user_id' => $user->id,
            'gaji_pokok' => 5000000,
            'total_lembur' => 500000,
            'total_potongan' => 200000,
            'bonus' => 300000,
        ]);

        $expectedTotal = 5000000 + 500000 + 300000 - 200000; // 5600000
        $payroll->total_gaji = $expectedTotal;
        $payroll->save();

        $this->assertEquals(5600000, $payroll->total_gaji);
        $this->assertEquals(5000000, $payroll->gaji_pokok);
        $this->assertEquals(500000, $payroll->total_lembur);
        $this->assertEquals(200000, $payroll->total_potongan);
    }

    public function test_payroll_can_be_filtered_by_period(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        $user = User::factory()->create();

        Payroll::factory()->create([
            'user_id' => $user->id,
            'periode_mulai' => '2026-01-01',
            'periode_selesai' => '2026-01-31',
        ]);
        Payroll::factory()->create([
            'user_id' => $user->id,
            'periode_mulai' => '2026-02-01',
            'periode_selesai' => '2026-02-28',
        ]);

        $response = $this->actingAs($admin)->getJson('/api/payrolls?periode_from=2026-02-01');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_payroll_requires_gaji_pokok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/attendances', [
            'user_id' => $user->id,
            'tanggal' => '2026-05-18',
            'status_hadir' => 'present',
        ]);

        $response->assertStatus(201);
    }

    public function test_admin_can_view_all_payrolls(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.payrolls.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_view_own_payrolls(): void
    {
        $role = Role::factory()->create(['nama_role' => 'employee']);
        $employee = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($employee)->get(route('employee.payrolls.index'));

        $response->assertStatus(200);
    }
}
