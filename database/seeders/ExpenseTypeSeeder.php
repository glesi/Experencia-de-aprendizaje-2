<?php
namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'Luz', 'description' => 'Gastos de electricidad'],
            ['name' => 'Agua', 'description' => 'Gastos de agua'],
            ['name' => 'Gas', 'description' => 'Gastos de gas'],
            ['name' => 'Ropa', 'description' => 'Gastos en vestimenta'],
            ['name' => 'Comida', 'description' => 'Gastos en alimentación'],
            ['name' => 'Casa', 'description' => 'Gastos de vivienda'],
            ['name' => 'Otras', 'description' => 'Otros gastos'],
        ];

        foreach ($types as $type) {
            ExpenseType::create($type);
        }
    }
}