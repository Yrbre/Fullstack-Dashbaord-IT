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
            'role' => 'ADMIN',
        ]);

        \App\Models\Activity::create([
            'name' => 'STAND BY',
            'location' => 'IT OFFICE',
        ]);
        \App\Models\Activity::create([
            'name' => 'MUSHALLA',
            'location' => 'MUSHALLA',
        ]);
        \App\Models\Activity::create([
            'name' => 'TOILET',
            'location' => 'TOILET',
        ]);
        \App\Models\Activity::create([
            'name' => 'MASJID',
            'location' => 'MASJID',
        ]);
        \App\Models\Activity::create([
            'name' => 'PANTRY',
            'location' => 'PANTRY',
        ]);
        \App\Models\Activity::create([
            'name' => 'KANTIN',
            'location' => 'KANTIN',
        ]);
        \App\Models\Activity::create([
            'name' => 'OUT OF OFFICE',
            'location' => 'OUT OF OFFICE',
        ]);

        \App\Models\Category::create([
            'name' => 'ADMINISTRATION',
        ]);

        \App\Models\Category::create([
            'name' => 'HARDWARE INSTALLATION',
        ]);
        \App\Models\Category::create([
            'name' => 'SOFTWARE DEVELOPMENT',
        ]);
        \App\Models\Category::create([
            'name' => 'SUPERVISORY',
        ]);
        \App\Models\Category::create([
            'name' => 'MEETING',
        ]);
        \App\Models\Category::create([
            'name' => 'ROUTINE WORK',
        ]);
        \App\Models\Category::create([
            'name' => 'TROUBLESHOOTING',
        ]);
        \App\Models\Category::create([
            'name' => 'OTHERS',
        ]);
    }
}
