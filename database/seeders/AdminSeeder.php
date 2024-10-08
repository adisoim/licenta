<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    private static string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'adi',
            'email' => 'adi@email.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ]);
        $user->assignRole('admin');
    }
}
