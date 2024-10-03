<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Jhon Walter',
            'email' => 'jhon@mailinator.com',
            'password' => Hash::make('admin@123'),
            'is_admin' => '1',
            'status' => '1'
        ];

        User::create($user);
    }
}
