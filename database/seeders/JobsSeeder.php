<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert 10 random job records
        foreach (range(1, 10) as $index) {
            DB::table('jobs')->insert([
                'title' => $faker->jobTitle,
                'company' => $faker->company,
                'requirements' => $faker->sentence(10),
                'job_type' => $faker->word,
                'experience_level' => $faker->randomElement(['Entry Level', 'Mid Level', 'Senior Level']),
                'min_salary' => $faker->randomFloat(2, 30000, 80000),
                'max_salary' => $faker->randomFloat(2, 80000, 150000),
                'location' => $faker->city,
                'salary_type' => $faker->randomElement(['Hourly', 'Annual']),
                'application_deadline' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'is_featured' => $faker->boolean(50), // 50% chance of being featured
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
