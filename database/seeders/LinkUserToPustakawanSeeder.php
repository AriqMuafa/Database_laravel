<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pustakawan;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LinkUserToPustakawanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Role 'pustakawan'
        $pustakawanRole = Role::where('name', 'pustakawan')->first();

        if (!$pustakawanRole) {
            $this->command->error("FATAL: Role 'pustakawan' tidak ditemukan.");
            return;
        }

        // 2. Ambil pustakawan yang belum punya user_id
        $pustakawans = Pustakawan::whereNull('user_id')->get();
        $defaultPassword = Hash::make('password'); // Password default

        foreach ($pustakawans as $pustakawan) {
            // Buat email dummy dari nama (misal: rina-amelia -> rina.amelia@library.com)
            $email = str_replace('-', '.', Str::slug($pustakawan->nama)) . '@library.com';

            // Cek apakah user sudah ada berdasarkan email (untuk menghindari duplikat)
            $user = User::where('email', $email)->first();

            if (!$user) {
                // 3. JIKA TIDAK ADA, BUAT USER BARU
                try {
                    $user = User::create([
                        'name' => $pustakawan->nama,
                        'email' => $email,
                        'password' => $defaultPassword,
                        'role_id' => $pustakawanRole->id,
                        'email_verified_at' => now(),
                    ]);
                    $this->command->info("  [Created] User baru dibuat untuk: " . $pustakawan->nama);
                } catch (\Exception $e) {
                    $this->command->error("  [Gagal] Gagal membuat user untuk " . $pustakawan->nama);
                    continue;
                }
            } else {
                $this->command->warn("  [Found] User sudah ada, menghubungkan...");
            }

            // 4. Hubungkan Pustakawan ke User tersebut
            $pustakawan->user_id = $user->id;
            $pustakawan->save();

            $this->command->info("  [Linked] Sukses menghubungkan {$pustakawan->nama} ke User ID: {$user->id}");
        }
    }
}
