<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Sets a known weak password on the local admin account. Local dev only,
     * refuses to run in production so it never overwrites a real password.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command?->error('LocalAdminSeeder no corre en production.');

            return;
        }

        $user = User::where('email', 'admin@nankiperu.com')->first();

        if (! $user) {
            $this->command?->error('admin@nankiperu.com no existe. Corre DatabaseSeeder primero.');

            return;
        }

        $user->password = 'password123';
        $user->save();

        $this->command?->warn('admin@nankiperu.com password -> password123');
    }
}
