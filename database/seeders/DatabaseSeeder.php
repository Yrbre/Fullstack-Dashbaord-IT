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

        $activities = [
            ['name' => 'STAND BY', 'location' => 'IT OFFICE'],
            ['name' => 'DEVELOPMENT', 'location' => 'IT OFFICE'],
            ['name' => 'MUSHALLA', 'location' => 'MUSHALLA'],
            ['name' => 'TOILET', 'location' => 'TOILET'],
            ['name' => 'MASJID', 'location' => 'MASJID'],
            ['name' => 'PANTRY', 'location' => 'PANTRY'],
            ['name' => 'KANTIN', 'location' => 'KANTIN'],
            ['name' => 'OUT OF OFFICE', 'location' => 'OUT OF OFFICE'],
        ];

        foreach ($activities as $activity) {
            \App\Models\Activity::create($activity);
        }

        $categories = [
            'ADMINISTRATION',
            'HARDWARE INSTALLATION',
            'SOFTWARE DEVELOPMENT',
            'SUPERVISORY',
            'MEETING',
            'ROUTINE WORK',
            'TROUBLESHOOTING',
            'OTHERS',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category
            ]);
        }


        $departments = [
            'ACC',
            'QARD',
            'BA/ESH',
            'MARKETING',
            'HRD',
            'GA',
            'CORSEC',
            'ENG',
            'PURCH',
            'IT',
            'SF',
            'FY1',
            'FY2',
            'FY3',
            'PBX',
            'PCP',
            'U1',
            'U2',
        ];

        foreach ($departments as $dept) {
            \App\Models\EndUser::create([
                'department' => $dept
            ]);
        }

        \App\Models\Location::create([
            'location'  => 'IT OFFICE'
        ]);
    }
}
