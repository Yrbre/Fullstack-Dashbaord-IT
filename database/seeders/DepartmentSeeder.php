<?

namespace Database\Seeders;

use App\Models\EndUser;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'IT',
            'HRD',
            'GA',
            'CORSEC',
            'ENG',
            'PURCH',
            'BA/ESH',
            'QARD',
            'ACC'
        ];

        foreach ($departments as $dept) {
            EndUser::create([
                'department' => $dept
            ]);
        }
    }
}
