<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statues = [
            ['name' => 'Pending', 'label' => StatusEnum::PENDING->value],
            ['name' => 'Canceled', 'label' => StatusEnum::CANCELLED->value],
            ['name' => 'In Progress', 'label' => StatusEnum::IN_PROGRESS->value],
            ['name' => 'Completed', 'label' => StatusEnum::COMPLETED->value],
        ];

        foreach ($statues as $statue) {
            Status::updateOrCreate(['label' => $statue['label']], ['name' => $statue['name']]);
        }
    }
}
