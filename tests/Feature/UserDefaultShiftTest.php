<?php

namespace Tests\Feature;

use App\Models\Shift;
use App\Models\User;
use App\Models\UserShift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class UserDefaultShiftTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
        $this->seed(\Database\Seeders\ShiftSeeder::class);
    }

    public function test_creating_user_assigns_default_shift(): void
    {
        $admin = $this->createAdmin();
        $role = \App\Models\Role::where('nama_role', 'employee')->first();
        $department = \App\Models\Department::first();
        $jobTitle = \App\Models\JobTitle::first();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'nama_lengkap' => 'New Employee',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'department_id' => $department->id,
            'job_title_id' => $jobTitle->id,
            'role_id' => $role->id,
            'tipe_gaji' => 'monthly',
            'jumlah_gaji' => 5000000,
            'tanggal_masuk' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $user = User::where('email', 'new@example.com')->firstOrFail();
        $this->assertDatabaseHas('user_shifts', [
            'user_id' => $user->id,
            'shift_id' => Shift::defaultShift()->id,
        ]);
    }
}