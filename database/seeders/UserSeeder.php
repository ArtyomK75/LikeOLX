<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users[] = [
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('Qwerty123'),
            'role_id' => 1
        ];
        $users[] = [
            'name' => 'Moderator',
            'email' => 'moderator@test.com',
            'password' => Hash::make('Qwerty123'),
            'role_id' => 2
        ];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'name' => Str::random(10),
                'email' => Str::random(8) . '@gmail.com',
                'password' => Hash::make('Qwerty123'),
                'role_id' => 3
            ];
        }
        User::insert($users);
    }
}
