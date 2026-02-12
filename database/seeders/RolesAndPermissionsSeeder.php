<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'moderator']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@wecarepets.ge',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');
    }
}
