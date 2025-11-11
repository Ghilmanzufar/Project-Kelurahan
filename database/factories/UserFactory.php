<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash; // <<< TAMBAHKAN BARIS INI
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password; // <<< TAMBAHKAN BARIS INI

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // HAPUS BARIS INI JIKA TABEL 'users' ANDA TIDAK MEMILIKI KOLOM 'name'
            // 'name' => fake()->name(), 
            // Ini adalah nama lengkap yang diminta oleh error
            'nama_lengkap' => fake()->name(), // <<< TAMBAHKAN BARIS INI
            'username' => fake()->unique()->userName(), // Pastikan ini ada dan sesuai
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'warga',
            'jabatan' => fake()->jobTitle(), // Pastikan ini ada dan sesuai
            'status' => 'aktif', // Pastikan ini ada dan sesuai
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
