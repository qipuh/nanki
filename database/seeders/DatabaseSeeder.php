<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Admin credentials are read from ADMIN_EMAIL / ADMIN_PASSWORD env vars
     * so real passwords never end up in source control. Without them, a
     * random password is generated and printed once.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@nankiperu.com');
        $password = env('ADMIN_PASSWORD');

        if (! User::where('email', $email)->exists()) {
            $password ??= Str::password(16);

            User::create([
                'name' => 'Admin Nanki',
                'email' => $email,
                'password' => $password,
            ]);

            if (! env('ADMIN_PASSWORD')) {
                $this->command?->warn("Admin creado: {$email} / {$password} (guarda esta contraseña, no se mostrará de nuevo)");
            }
        }

        Setting::set('site_name', 'Nanki');
    }
}
