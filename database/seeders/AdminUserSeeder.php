<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'fullname' => 'Admin User',
            'email' => 'cuevas.school.project@gmail.com',
            'password' => Hash::make('SchoolProject00!'),
            'status' => 'active',
            'phone' => '09684976467'
        ]);

        $admin->assignRole('admin');
    }
}
