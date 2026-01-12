<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD'))
            ]
        );

        $this->call([
            SettingSeeder::class,
            PermissionSeeder::class,
            AssignAllPermissionsToAdminSeeder::class
        ]);
    }
}
