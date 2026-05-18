<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $role = Role::first() ?? Role::factory()->create();

        return [
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => $role->id,
            'job_title_id' => null,
            'department_id' => null,
            'tipe_gaji' => fake()->randomElement(['monthly', 'daily', 'hourly']),
            'jumlah_gaji' => fake()->numberBetween(3000000, 15000000),
            'tanggal_masuk' => fake()->date(),
            'status_akun' => 'active',
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
