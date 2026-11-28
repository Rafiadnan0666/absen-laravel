<?php

namespace Tests\Feature\Api;

use App\Models\Attendance;
use App\Models\Location;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\Concerns\InteractsWithRoles;
use Tests\TestCase;

class ApiAuthorizationTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
        $this->createOffice();
    }

    private function createOffice(int $radiusMeter = 100): Location
    {
        return Location::create([
            'nama_lokasi' => 'Kantor Pusat',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'radius_meter' => $radiusMeter,
        ]);
    }

    private function getAuthHeaders(User $user): array
    {
        $token = $user->createToken('api-token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_unauthenticated_cannot_access_api(): void
    {
        $response = $this->getJson('/api/employee/attendances');
        $response->assertStatus(401);
    }

    public function test_employee_can_only_access_own_attendance(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();

        Attendance::factory()->create(['user_id' => $employee1->id]);
        Attendance::factory()->create(['user_id' => $employee2->id]);

        $response = $this->withHeaders($this->getAuthHeaders($employee1))
            ->getJson('/api/employee/attendances');

        $response->assertStatus(200);
        $data = $response->json('data');
        foreach ($data as $attendance) {
            $this->assertEquals($employee1->id, $attendance['user_id']);
        }
    }

    public function test_employee_cannot_access_other_employee_attendance_via_id(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();
        $attendance = Attendance::factory()->create(['user_id' => $employee2->id]);

        $response = $this->withHeaders($this->getAuthHeaders($employee1))
            ->getJson("/api/employee/attendances/{$attendance->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_access_all_attendances(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();

        Attendance::factory()->create(['user_id' => $employee->id]);

        $response = $this->withHeaders($this->getAuthHeaders($admin))
            ->getJson('/api/admin/attendances');

        $response->assertStatus(200);
    }

    public function test_hr_can_access_all_attendances(): void
    {
        $hr = $this->createHR();
        $employee = $this->createEmployee();

        Attendance::factory()->create(['user_id' => $employee->id]);

        $response = $this->withHeaders($this->getAuthHeaders($hr))
            ->getJson('/api/admin/attendances');

        $response->assertStatus(200);
    }

    public function test_employee_cannot_access_admin_attendance_endpoint(): void
    {
        $employee = $this->createEmployee();

        $response = $this->withHeaders($this->getAuthHeaders($employee))
            ->getJson('/api/admin/attendances');

        $response->assertStatus(403);
    }

    public function test_employee_can_check_in_and_out(): void
    {
        $employee = $this->createEmployee();
        $location = $this->createOffice();

        $checkInResponse = $this->withHeaders($this->getAuthHeaders($employee))
            ->postJson('/api/employee/attendances/check-in', [
                'location_id' => $location->id,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ]);

        $checkInResponse->assertStatus(201);

        $checkOutResponse = $this->withHeaders($this->getAuthHeaders($employee))
            ->postJson('/api/employee/attendances/check-out', [
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ]);

        $checkOutResponse->assertStatus(200);
    }

    public function test_duplicate_check_in_prevented(): void
    {
        $employee = $this->createEmployee();
        $location = $this->createOffice();

        $this->withHeaders($this->getAuthHeaders($employee))
            ->postJson('/api/employee/attendances/check-in', [
                'location_id' => $location->id,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ])
            ->assertStatus(201);

        $response = $this->withHeaders($this->getAuthHeaders($employee))
            ->postJson('/api/employee/attendances/check-in', [
                'location_id' => $location->id,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ]);

        $response->assertStatus(409);
    }

    public function test_employee_can_only_access_own_payroll(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();

        Payroll::factory()->create(['user_id' => $employee1->id]);
        Payroll::factory()->create(['user_id' => $employee2->id]);

        $response = $this->withHeaders($this->getAuthHeaders($employee1))
            ->getJson('/api/employee/payrolls');

        $response->assertStatus(200);
        $data = $response->json('data');
        foreach ($data as $payroll) {
            $this->assertEquals($employee1->id, $payroll['user_id']);
        }
    }

    public function test_admin_can_calculate_payroll_for_any_user(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();

        $response = $this->withHeaders($this->getAuthHeaders($admin))
            ->postJson('/api/admin/payrolls/calculate', [
                'user_id' => $employee->id,
                'periode_mulai' => now()->startOfMonth()->toDateString(),
                'periode_selesai' => now()->endOfMonth()->toDateString(),
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user',
            'period',
            'calculation' => [
                'gaji_pokok',
                'total_lembur',
                'total_potongan',
                'bonus',
                'reimbursements',
                'total_gaji',
                'breakdown',
            ],
        ]);
    }

    public function test_employee_cannot_calculate_payroll_for_other_users(): void
    {
        $employee1 = $this->createEmployee();
        $employee2 = $this->createEmployee();

        $response = $this->withHeaders($this->getAuthHeaders($employee1))
            ->postJson('/api/admin/payrolls/calculate', [
                'user_id' => $employee2->id,
                'periode_mulai' => now()->startOfMonth()->toDateString(),
                'periode_selesai' => now()->endOfMonth()->toDateString(),
            ]);

        $response->assertStatus(403);
    }

    public function test_employee_can_calculate_own_payroll(): void
    {
        $employee = $this->createEmployee();

        $response = $this->withHeaders($this->getAuthHeaders($employee))
            ->getJson('/api/employee/payrolls/calculate?periode_mulai=' . now()->startOfMonth()->toDateString() . '&periode_selesai=' . now()->endOfMonth()->toDateString());

        $response->assertStatus(200);
    }

    public function test_inactive_user_cannot_authenticate(): void
    {
        $employee = $this->createEmployee();
        $employee->update(['status_akun' => 'inactive']);

        $response = $this->withHeaders($this->getAuthHeaders($employee))
            ->getJson('/api/employee/attendances');

        $response->assertStatus(401);
    }

    public function test_duplicate_payroll_prevented(): void
    {
        $admin = $this->createAdmin();
        $employee = $this->createEmployee();

        $periodeMulai = now()->startOfMonth()->toDateString();
        $periodeSelesai = now()->endOfMonth()->toDateString();

        $this->withHeaders($this->getAuthHeaders($admin))
            ->postJson('/api/admin/payrolls/generate-from-calculation', [
                'user_id' => $employee->id,
                'periode_mulai' => $periodeMulai,
                'periode_selesai' => $periodeSelesai,
                'gaji_pokok' => 5000000,
                'total_lembur' => 0,
                'total_potongan' => 0,
                'bonus' => 0,
                'total_gaji' => 5000000,
            ])
            ->assertStatus(201);

        $response = $this->withHeaders($this->getAuthHeaders($admin))
            ->postJson('/api/admin/payrolls/generate-from-calculation', [
                'user_id' => $employee->id,
                'periode_mulai' => $periodeMulai,
                'periode_selesai' => $periodeSelesai,
                'gaji_pokok' => 5000000,
                'total_lembur' => 0,
                'total_potongan' => 0,
                'bonus' => 0,
                'total_gaji' => 5000000,
            ]);

        $response->assertStatus(409);
    }
}