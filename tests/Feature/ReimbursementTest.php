<?php

namespace Tests\Feature;

use App\Models\Reimbursement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class ReimbursementTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_employee_can_view_reimbursement_page(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)
            ->get(route('employee.reimbursements.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_submit_reimbursement(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)->post(route('employee.reimbursements.store'), [
            'kategori' => 'medical',
            'jumlah' => 500000,
            'tanggal' => now()->toDateString(),
            'deskripsi' => 'Pemeriksaan kesehatan rutin',
        ]);

        $response->assertRedirect(route('employee.reimbursements.index'));

        $this->assertDatabaseHas('reimbursements', [
            'user_id' => $user->id,
            'kategori' => 'medical',
            'jumlah' => 500000,
            'status' => 'pending',
        ]);
    }

    public function test_reimbursement_requires_valid_amount(): void
    {
        $user = $this->createEmployee();

        $response = $this->actingAs($user)->post(route('employee.reimbursements.store'), [
            'kategori' => 'medical',
            'jumlah' => 500,
            'tanggal' => now()->toDateString(),
            'deskripsi' => 'Test reimbursement',
        ]);

        $response->assertSessionHasErrors('jumlah');
    }

    public function test_employee_can_view_their_reimbursement_history(): void
    {
        $user = $this->createEmployee();
        Reimbursement::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('employee.reimbursements.index'));

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_reimbursement(): void
    {
        $response = $this->get(route('employee.reimbursements.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_hr_can_view_all_pending_reimbursements(): void
    {
        $hr = $this->createHR();
        Reimbursement::factory()->count(3)->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($hr)
            ->get(route('hr.reimbursements.index'));

        $response->assertStatus(200);
    }

    public function test_hr_can_approve_reimbursement(): void
    {
        $employee = $this->createEmployee();
        $hr = $this->createHR();
        $reimbursement = Reimbursement::factory()->create([
            'user_id' => $employee->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($hr)
            ->post(route('hr.reimbursements.approve', $reimbursement));

        $response->assertRedirect();
        $reimbursement->refresh();
        $this->assertEquals('approved', $reimbursement->status);
        $this->assertEquals($hr->id, $reimbursement->approved_by);
    }

    public function test_hr_can_reject_reimbursement(): void
    {
        $employee = $this->createEmployee();
        $hr = $this->createHR();
        $reimbursement = Reimbursement::factory()->create([
            'user_id' => $employee->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($hr)
            ->post(route('hr.reimbursements.reject', $reimbursement));

        $response->assertRedirect();
        $reimbursement->refresh();
        $this->assertEquals('rejected', $reimbursement->status);
        $this->assertEquals($hr->id, $reimbursement->approved_by);
    }

    public function test_employee_cannot_approve_reimbursement(): void
    {
        $employee = $this->createEmployee();
        $reimbursement = Reimbursement::factory()->create([
            'user_id' => $employee->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($employee)
            ->post(route('hr.reimbursements.approve', $reimbursement));

        $response->assertStatus(302);
        $reimbursement->refresh();
        $this->assertEquals('pending', $reimbursement->status);
        $this->assertNull($reimbursement->approved_by);
    }

    public function test_employee_cannot_reject_reimbursement(): void
    {
        $employee = $this->createEmployee();
        $reimbursement = Reimbursement::factory()->create([
            'user_id' => $employee->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($employee)
            ->post(route('hr.reimbursements.reject', $reimbursement));

        $response->assertStatus(302);
        $reimbursement->refresh();
        $this->assertEquals('pending', $reimbursement->status);
        $this->assertNull($reimbursement->approved_by);
    }

    public function test_employee_cannot_access_hr_reimbursement_page(): void
    {
        $employee = $this->createEmployee();

        $response = $this->actingAs($employee)
            ->get(route('hr.reimbursements.index'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_employee_cannot_view_other_employee_reimbursement(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();
        $reimbursement = Reimbursement::factory()->create([
            'user_id' => $employee2->id,
        ]);

        $response = $this->actingAs($employee1)
            ->get(route('employee.reimbursements.show', $reimbursement));

        $response->assertStatus(403);
    }

    public function test_hr_cannot_access_admin_reimbursement_page(): void
    {
        $hr = $this->createHR();

        $response = $this->actingAs($hr)
            ->get(route('admin.reimbursements.index'));

        $response->assertRedirect(route('dashboard'));
    }
}
