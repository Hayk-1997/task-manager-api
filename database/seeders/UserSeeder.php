<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_available' => true,
        ]);
        $adminUser->roles()->attach($adminRole->id);

        // Sample users
        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com'],
            ['name' => 'Sarah Wilson', 'email' => 'sarah@example.com'],
        ];

        $userRole = Role::where('name', 'user')->first();

        foreach ($users as $userData) {
            $user = User::create([
                ...$userData,
                'password' => Hash::make('password'),
                'is_available' => rand(0, 1),
            ]);
            $user->roles()->attach($userRole->id);
        }
    }
}
