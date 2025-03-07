<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->count(10)->create()->each(function ($project) {
            $project->users()->attach(User::inRandomOrder()->take(rand(1, 3))->pluck('id'));
            // Assign attribute values to the project
            Attribute::all()->each(function ($attribute) use ($project) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'entity_type' => Project::class,
                    'value' => $this->generateAttributeValue($attribute->type),
                ]);
            });
        });
    }

    /**
     * Generate a random value based on the attribute type.
     *
     * @param string $type
     * @return mixed
     */
    private function generateAttributeValue(string $type)
    {
        switch ($type) {
            case 'text':
                return fake()->word;
            case 'date':
                return fake()->date;
            case 'number':
                return fake()->randomNumber;
            case 'select':
                return fake()->randomElement(['Option1', 'Option2', 'Option3']);
            default:
                return fake()->word;
        }
    }
}
