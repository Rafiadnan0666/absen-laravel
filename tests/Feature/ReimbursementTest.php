<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reimbursement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReimbursementTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_view_reimbursement_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('employee.reimbursements.index'));

        $response->assertStatus(200);
    }

    public function test_employee_can_submit_reimbursement(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('employee.reimbursements.store'), [
            'kategori' => 'medical',
            'jumlah' => 500000,
            'tanggal' => now()->toDateString(),
            'deskripsi' => 'Pemeriksaan kesehatan rutin',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reimbursements', [
            'user_id' => $user->id,
            'kategori' => 'medical',
            'jumlah' => 500000,
        ]);
    }

    public function test_reimbursement_requires_valid_amount(): void
    {
        $user = User::factory()->create();

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
        $user = User::factory()->create();
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
        $user = User::factory()->create();
        Reimbursement::factory()->count(3)->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)
            ->get(route('hr.reimbursements.index'));

        $response->assertStatus(200);
    }
}