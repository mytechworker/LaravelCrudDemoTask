<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Employee::create([
                'name' => $faker->name,
                'job_title' => $faker->jobTitle,
                'salary' => $faker->randomFloat(2, 2000, 10000),
            ]);
        }
    }
}
