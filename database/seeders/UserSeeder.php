<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cached permissions and roles
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $role1 = Role::create(['name' => 'user']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'super-admin']);
        $role4 = Role::create(['name' => 'contract-supervisor']);

        // Create users with hashed passwords
        $user = User::create([
            'name' => 'User',
            'email' => 'user@medadalaamal.com',
            'password' => Hash::make('sZCq),Emx,;T@J6i'), // 👈 hashed password
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@medadalaamal.com',
            'password' => Hash::make('jd}cUdwz7{F(0KN]'),
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@medadalaamal.com',
            'password' => Hash::make('2XD3gH9a{S4hWFMo'),
        ]);
        $user->assignRole($role3);

        $user = User::create([
            'name' => 'Contract Supervisor',
            'email' => 'contract-supervisor@medadalaamal.com',
            'password' => Hash::make('{@!)0)q^%~l[Uo2C'),
        ]);
        $user->assignRole($role4);
    }
}
