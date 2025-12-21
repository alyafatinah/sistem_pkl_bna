<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HumasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Humas',
            'username' => 'humas',
            'email' => 'humas@gmail.com',
            'password' => Hash::make('humas123'),
            'role_id' => 2,
        ]);
    }
}
