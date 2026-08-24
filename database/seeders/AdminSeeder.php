<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@sukun.com',
            'password' => Hash::make('rahasia123') // Otomatis dienkripsi jadi string acak
        ]);
    }
}