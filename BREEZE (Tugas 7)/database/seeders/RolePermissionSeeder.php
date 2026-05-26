<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $permissions = [
            'lihat dashboard admin',
            'lihat dashboard user',
            'kelola user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole->givePermissionTo([
            'lihat dashboard admin',
            'kelola user',
        ]);

        $userRole->givePermissionTo([
            'lihat dashboard user',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}