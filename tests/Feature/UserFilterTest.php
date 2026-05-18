<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_users_by_status(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['filterStatus' => 'active']));

        $response->assertStatus(200);
    }

    public function test_admin_can_search_users(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'test']));

        $response->assertStatus(200);
    }

    public function test_ajax_filter_returns_partial_html(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['ajax' => 1]), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
    }

    public function test_ajax_filter_returns_html_not_json(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['ajax' => 1, 'filterStatus' => 'active']), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertSee('<tr', escape: false);
    }

    public function test_admin_can_filter_leaves_by_date_range(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.leaves.index', [
            'dateFrom' => '2026-01-01',
            'dateTo' => '2026-12-31',
        ]));

        $response->assertStatus(200);
    }

    public function test_admin_can_filter_attendances_by_department(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);
        $dept = Department::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.attendances.index', ['filterDept' => $dept->id]));

        $response->assertStatus(200);
    }

    public function test_admin_can_filter_reimbursements_by_amount(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($admin)->get(route('admin.reimbursements.index', [
            'amountMin' => 10000,
            'amountMax' => 5000000,
        ]));

        $response->assertStatus(200);
    }
}
