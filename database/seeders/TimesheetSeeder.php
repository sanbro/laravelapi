<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $projects = Project::all();

        foreach ($users as $user) {
            foreach ($projects->random(2) as $project) { // Assign 2 random projects per user
                Timesheet::factory()->create([
                    // 'task_name' => 'Task for ' . $project->name,
                    // 'date' => now()->subDays(rand(1, 30)),
                    // 'hours' => rand(1, 8),
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}
