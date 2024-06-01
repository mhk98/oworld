<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'O\'World',
            'last_name' => 'Admin',
            'email' => 'admin@oworldbd.com',
            'phone' => '01671382661',
            'password' => Hash::make('Admin12345#'),
            'is_merchant' => false,
            'is_admin' => true,
            'status' => 'active'
        ]);

        echo 'Admin Data Insert';
    }
}
