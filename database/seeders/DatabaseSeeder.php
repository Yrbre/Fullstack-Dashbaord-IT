<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@tifico.co.id',
            'password' => Hash::make('1'),
            'phone' => '1234567890',
            'role' => 'admin',
        ]);

        \App\Models\Activity::factory()->create([
            'name' => 'STAND BY',
            'location' => 'IT OFFICE',
        ]);
    }
}
