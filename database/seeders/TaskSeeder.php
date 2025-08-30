<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        $tasks = [
            [
                'title' => 'Office Cleaning',
                'description' => 'Deep clean the main office area',
                'due_date' => now()->addDays(3),
                'status' => StatusEnum::PENDING->value,
            ],
            [
                'title' => 'Equipment Maintenance',
                'description' => 'Check and maintain all office equipment',
                'due_date' => now()->addDays(7),
                'status' => StatusEnum::IN_PROGRESS->value,
            ],
            [
                'title' => 'Supply Inventory',
                'description' => 'Count and update office supply inventory',
                'due_date' => now()->addDays(1),
                'status' => StatusEnum::COMPLETED->value,
            ],
            [
                'title' => 'Lorem ipsum',
                'description' => 'Lorem Ipsum',
                'due_date' => now()->addDays(3),
                'status' => StatusEnum::COMPLETED->value,
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::create([
                ...$taskData,
                'assigned_user_id' => $users->random()->id,
                'created_by' => $admin->id,
            ]);
        }
    }
}
