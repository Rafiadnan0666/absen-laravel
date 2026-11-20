<?php

namespace Tests\Feature;

use App\Models\Shift;
use App\Models\UserShift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_default_shift_is_seeded(): void
    {
        $this->seed(\Database\Seeders\ShiftSeeder::class);

        $this->assertDatabaseHas('shifts', ['is_default' => true]);
        $this->assertNotNull(Shift::defaultShift());
    }

    public function test_admin_can_create_shift_with_default_flag(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.shifts.store'), [
            'nama_shift' => 'Night Shift',
            'jam_masuk' => '22:00',
            'jam_pulang' => '06:00',
            'toleransi_telat_menit' => 10,
            'is_default' => true,
        ]);

        $response->assertRedirect(route('admin.shifts.index'));
        $this->assertDatabaseHas('shifts', ['nama_shift' => 'Night Shift', 'is_default' => true]);
    }

    public function test_user_shift_uses_default_shift_when_not_provided(): void
    {
        $this->seed(\Database\Seeders\ShiftSeeder::class);
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();

        $response = $this->actingAs($admin)->post(route('admin.user-shifts.store'), [
            'user_id' => $employee->id,
            'tanggal_shift' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.user-shifts.index'));
        $this->assertDatabaseHas('user_shifts', [
            'user_id' => $employee->id,
            'shift_id' => Shift::defaultShift()->id,
        ]);
    }
}