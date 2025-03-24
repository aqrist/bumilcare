<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@pregnancy.test',
                'password' => 'admin123',
                'role' => 'admin'
            ],
            [
                'name' => 'Doctor User',
                'email' => 'doctor@pregnancy.test',
                'password' => 'doctor123',
                'role' => 'doctor'
            ],
            [
                'name' => 'Nurse User',
                'email' => 'nurse@pregnancy.test',
                'password' => 'nurse123',
                'role' => 'nurse'
            ],
            [
                'name' => 'Pharmacist User',
                'email' => 'pharmacist@pregnancy.test',
                'password' => 'pharmacist123',
                'role' => 'pharmacist'
            ],
            [
                'name' => 'Cashier User',
                'email' => 'cashier@pregnancy.test',
                'password' => 'cashier123',
                'role' => 'cashier'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            $role = Role::where('name', $userData['role'])->first();
            $user->roles()->attach($role);
        }
    }
}
