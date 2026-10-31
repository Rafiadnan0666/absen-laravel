<?php

namespace Tests\Feature;

use App\Mail\PayrollStatusMail;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class PayrollTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    private function createPayroll(User $employee, array $overrides = []): Payroll
    {
        return Payroll::create(array_merge([
            'user_id' => $employee->id,
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
            'gaji_pokok' => 5000000,
            'total_lembur' => 0,
            'total_potongan' => 0,
            'bonus' => 0,
            'total_gaji' => 5000000,
            'status_pembayaran' => 'pending',
        ], $overrides));
    }

    public function test_admin_can_create_payroll(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();

        $response = $this->actingAs($admin)->post(route('admin.payrolls.store'), [
            'user_id' => $employee->id,
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
            'gaji_pokok' => 5000000,
            'total_lembur' => 250000,
            'total_potongan' => 100000,
            'bonus' => 500000,
        ]);

        $response->assertRedirect(route('admin.payrolls.index'));

        $this->assertDatabaseHas('payrolls', [
            'user_id' => $employee->id,
            'status_pembayaran' => 'pending',
            'total_gaji' => 5650000,
        ]);

        $payroll = Payroll::where('user_id', $employee->id)->firstOrFail();
        $this->assertDatabaseHas('payroll_details', ['payroll_id' => $payroll->id]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'payroll.created',
            'auditable_type' => Payroll::class,
            'auditable_id' => $payroll->id,
        ]);
    }

    public function test_admin_can_confirm_payroll(): void
    {
        Mail::fake();

        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $response = $this->actingAs($admin)
            ->post(route('admin.payrolls.confirm', $payroll));

        $response->assertRedirect();
        $payroll->refresh();

        $this->assertNotNull($payroll->confirmed_at);
        $this->assertEquals($admin->id, $payroll->confirmed_by);
        $this->assertEquals('pending', $payroll->status_pembayaran);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'payroll.confirmed',
            'auditable_id' => $payroll->id,
        ]);
        Mail::assertQueued(PayrollStatusMail::class);
    }

    public function test_unconfirmed_payroll_cannot_be_marked_paid(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $response = $this->actingAs($admin)
            ->post(route('admin.payrolls.markPaid', $payroll));

        $response->assertRedirect();
        $response->assertSessionHasErrors('payroll');

        $payroll->refresh();
        $this->assertEquals('pending', $payroll->status_pembayaran);
        $this->assertNull($payroll->paid_at);
        $this->assertDatabaseMissing('audit_logs', [
            'action' => 'payroll.paid',
            'auditable_id' => $payroll->id,
        ]);
    }

    public function test_confirmed_payroll_can_be_marked_paid(): void
    {
        Mail::fake();

        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee, [
            'confirmed_by' => $admin->id,
            'confirmed_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.payrolls.markPaid', $payroll));

        $response->assertRedirect();
        $payroll->refresh();

        $this->assertEquals('paid', $payroll->status_pembayaran);
        $this->assertNotNull($payroll->paid_at);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'payroll.paid',
            'auditable_id' => $payroll->id,
        ]);
        Mail::assertQueued(PayrollStatusMail::class);
    }

    public function test_admin_can_reject_payroll_confirmation(): void
    {
        Mail::fake();

        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $response = $this->actingAs($admin)->post(route('admin.payrolls.reject', $payroll), [
            'rejection_reason' => 'Overtime hours do not match attendance records.',
        ]);

        $response->assertRedirect();
        $payroll->refresh();

        $this->assertNull($payroll->confirmed_at);
        $this->assertEquals('Overtime hours do not match attendance records.', $payroll->rejection_reason);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'payroll.rejected',
            'auditable_id' => $payroll->id,
        ]);
        Mail::assertQueued(PayrollStatusMail::class);
    }

    public function test_employee_cannot_confirm_payroll(): void
    {
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $response = $this->actingAs($employee)
            ->post(route('admin.payrolls.confirm', $payroll));

        $response->assertRedirect(route('dashboard'));

        $payroll->refresh();
        $this->assertNull($payroll->confirmed_at);
        $this->assertDatabaseMissing('audit_logs', [
            'action' => 'payroll.confirmed',
            'auditable_id' => $payroll->id,
        ]);
    }

    public function test_employee_cannot_mark_payroll_paid(): void
    {
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee, [
            'confirmed_at' => now(),
        ]);

        $response = $this->actingAs($employee)
            ->post(route('admin.payrolls.markPaid', $payroll));

        $response->assertRedirect(route('dashboard'));

        $payroll->refresh();
        $this->assertEquals('pending', $payroll->status_pembayaran);
        $this->assertNull($payroll->paid_at);
    }

    public function test_hr_cannot_confirm_payroll(): void
    {
        $hr = $this->createHR();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $response = $this->actingAs($hr)
            ->post(route('admin.payrolls.confirm', $payroll));

        $response->assertRedirect(route('dashboard'));

        $this->assertNull($payroll->fresh()->confirmed_at);
    }

    public function test_admin_can_view_audit_trail(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.index'));

        $response->assertStatus(200);
    }

    public function test_employee_cannot_view_audit_trail(): void
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($employee)->get(route('admin.audit-logs.index'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_payroll_show_displays_audit_trail(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee);

        $this->actingAs($admin)->post(route('admin.payrolls.confirm', $payroll));

        $response = $this->actingAs($admin)->get(route('admin.payrolls.show', $payroll));

        $response->assertStatus(200);
        $response->assertSee('Audit Trail');
        $response->assertSee('payroll.confirmed');
    }

    public function test_employee_cannot_view_other_employee_payroll(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();
        $payroll = $this->createPayroll($employee2);

        $response = $this->actingAs($employee1)
            ->get(route('employee.payrolls.show', $payroll));

        $response->assertStatus(403);
    }

    public function test_paid_payroll_cannot_be_edited(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();
        $payroll = $this->createPayroll($employee, [
            'confirmed_by' => $admin->id,
            'confirmed_at' => now(),
            'status_pembayaran' => 'paid',
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($admin)->put(route('admin.payrolls.update', $payroll), [
            'user_id' => $employee->id,
            'periode_mulai' => now()->startOfMonth()->toDateString(),
            'periode_selesai' => now()->endOfMonth()->toDateString(),
            'gaji_pokok' => 9000000,
            'total_lembur' => 0,
            'total_potongan' => 0,
            'bonus' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('payroll');

        $this->assertEquals(5000000, (float) $payroll->fresh()->gaji_pokok);
        $this->assertEquals('paid', $payroll->fresh()->status_pembayaran);
    }
}
