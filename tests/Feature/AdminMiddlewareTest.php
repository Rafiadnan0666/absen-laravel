<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_cannot_access_admin_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'employee']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertRedirect('/dashboard');
    }

    public function test_hr_cannot_access_admin_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'hr']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_users(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_employee_cannot_access_admin_users(): void
    {
        $role = Role::factory()->create(['nama_role' => 'employee']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertRedirect('/dashboard');
    }

    public function test_employee_cannot_access_hr_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'employee']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('hr.dashboard'));

        $response->assertRedirect('/dashboard');
    }

    public function test_hr_can_access_hr_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'hr']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('hr.dashboard'));

        $response->assertStatus(200);
    }

    public function test_admin_can_access_hr_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'admin']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('hr.dashboard'));

        $response->assertStatus(200);
    }

    public function test_employee_can_access_employee_dashboard(): void
    {
        $role = Role::factory()->create(['nama_role' => 'employee']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get(route('employee.dashboard'));

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
