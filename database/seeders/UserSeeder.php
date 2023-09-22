<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'roles' => 'ADMIN',
        ]);
        User::factory()->create([
            'name' => 'security',
            'email' => 'security@gmail.com',
            'password' => Hash::make('security'),
            'roles' => 'SECURITY',
        ]);
    }
}