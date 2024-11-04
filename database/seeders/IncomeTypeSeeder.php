<?php
namespace Database\Seeders;

use App\Models\IncomeType;
use Illuminate\Database\Seeder;

class IncomeTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Sueldo del mes', 'description' => 'Ingreso mensual por trabajo'],
            ['name' => 'Cheque de sistema', 'description' => 'Ingreso por sistema'],
            ['name' => 'Remesa', 'description' => 'Ingreso por remesa'],
        ];

        foreach ($types as $type) {
            IncomeType::create($type);
        }
    }
}