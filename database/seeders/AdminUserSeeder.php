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
            'fullname' => 'Hakdog Admin',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'phone' => '09876543211'
        ]);

        $admin->assignRole('admin');
    }
}
