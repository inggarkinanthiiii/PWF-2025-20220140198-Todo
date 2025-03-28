<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus admin lama jika ada
        User::where('email', 'admin@admin.com')->delete();

        // Buat 100 user
        User::factory(100)->create();

        // Buat user admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);

        // Ambil user_id yang ada
        $userIds = User::pluck('id');

        // Jika ada user, buat Todo
        if ($userIds->isNotEmpty()) {
            Todo::factory(100)->create([
                'user_id' => $userIds->random(),
            ]);
        } else {
            $this->command->warn("❌ Tidak ada user tersedia, Todo tidak dibuat!");
        }
    }
}
