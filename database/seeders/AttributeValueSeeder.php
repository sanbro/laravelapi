<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::all()->each(function ($project) {
            Attribute::all()->each(function ($attribute) use ($project) {
                AttributeValue::factory()->create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'entity_type' => Project::class,
                ]);
            });
        });
    }
}
