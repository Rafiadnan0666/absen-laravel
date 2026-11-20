<?php

namespace Tests\Feature;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class PayrollBulkTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_payroll_uses_employee_salary_when_not_provided(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $employee->update(['jumlah_gaji' => 7500000]);

        $response = $this->actingAs($admin)->post(route('admin.payrolls.store'), [
            'user_id' => $employee->id,
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.payrolls.index'));
        $this->assertDatabaseHas('payrolls', [
            'user_id' => $employee->id,
            'gaji_pokok' => 7500000,
        ]);
    }

    public function test_admin_can_bulk_create_payrolls(): void
    {
        $admin = $this->createAdmin();
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();
        $employee1->update(['jumlah_gaji' => 5000000]);
        $employee2->update(['jumlah_gaji' => 6000000]);

        $response = $this->actingAs($admin)->post(route('admin.payrolls.bulkStore'), [
            'user_ids' => [$employee1->id, $employee2->id],
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.payrolls.index'));
        $this->assertEquals(2, Payroll::count());
        $this->assertDatabaseHas('payrolls', ['user_id' => $employee1->id, 'gaji_pokok' => 5000000]);
        $this->assertDatabaseHas('payrolls', ['user_id' => $employee2->id, 'gaji_pokok' => 6000000]);
    }
}