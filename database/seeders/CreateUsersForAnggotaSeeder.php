<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Role; // <-- PASTIKAN INI DI-IMPORT
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // <-- Ini untuk membuat email

class CreateUsersForAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Cari Role 'anggota'. Ini PENTING!
        // Pastikan RoleSeeder Anda sudah membuat role 'anggota'.
        $anggotaRole = Role::where('name', 'anggota')->first();

        // 2. Jika role 'anggota' tidak ada, hentikan seeder dengan pesan error
        if (!$anggotaRole) {
            $this->command->error("===============================================================");
            $this->command->error("  FATAL: Role 'anggota' tidak ditemukan di tabel 'roles'.");
            $this->command->error("  Harap edit RoleSeeder.php untuk menambahkan 'anggota' dulu.");
            $this->command->error("===============================================================");
            return; // Hentikan proses
        }

        // 3. Ambil semua anggota yang kolom user_id nya masih NULL
        $anggotasToUpdate = Anggota::whereNull('user_id')->get();
        $defaultPassword = Hash::make('password'); // Password default untuk semua user baru

        $this->command->info("Menemukan " . $anggotasToUpdate->count() . " anggota yang belum punya akun user...");

        foreach ($anggotasToUpdate as $anggota) {
            
            // 4. Buat email unik (contoh: budi.santoso@example.com)
            // Str::slug mengubah "Budi Santoso" -> "budi-santoso"
            // str_replace mengubah "-" -> "."
            $baseEmail = str_replace('-', '.', Str::slug($anggota->nama));
            $email = $baseEmail . '@example.com';

            // 5. Cek dulu apakah user dengan email ini sudah ada
            $existingUser = User::where('email', $email)->first();
            
            if ($existingUser) {
                // Jika user-nya ada tapi belum ter-link, link-kan saja
                $anggota->user_id = $existingUser->id;
                $anggota->save();
                $this->command->warn("  [Skip] User {$email} sudah ada, langsung di-link ke anggota.");
                continue;
            }

            // 6. Buat User baru di tabel 'users'
            try {
                $newUser = User::create([
                    'name' => $anggota->nama,
                    'email' => $email,
                    'password' => $defaultPassword,
                    'role_id' => $anggotaRole->id, // Set role-nya ke ID 'anggota'
                    'email_verified_at' => now(), // (Opsional) Anggap email sudah terverifikasi
                ]);

                // 7. Update kolom user_id di tabel 'anggota' dengan ID user baru
                $anggota->user_id = $newUser->id;
                $anggota->save();

                $this->command->info("  [Sukses] User '{$newUser->name}' (email: {$email}) dibuat & di-link.");

            } catch (\Exception $e) {
                // Tangkap error jika ada (misal: email duplikat)
                $this->command->error("  [Gagal] Membuat user untuk '{$anggota->nama}'. Error: " . $e->getMessage());
            }
        }
        
        $this->command->info("Proses create user untuk anggota selesai.");
    }
}