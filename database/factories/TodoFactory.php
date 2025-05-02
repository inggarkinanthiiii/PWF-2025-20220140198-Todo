<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // Import User model
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada user yang terdaftar
        $user = User::inRandomOrder()->first();

        // Cek apakah user ada
        if (!$user) {
            // Jika tidak ada user, ambil ID default (misalnya user dengan ID = 1)
            $userId = User::first()->id ?? 1;
        } else {
            // Ambil user_id yang valid
            $userId = $user->id;
        }

        return [
            'user_id' => $userId,  // ID pengguna yang valid
            'title' => ucfirst(fake()->sentence()),  // Judul acak dengan kapitalisasi pertama
            'status' => rand(0, 1),  // Status selesai acak (0 atau 1)
        ];
    }
}
