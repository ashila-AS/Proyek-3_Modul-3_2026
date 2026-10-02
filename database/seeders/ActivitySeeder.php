<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::query()->insert([
            [
                'code' => 'ACT-001',
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository.',
                'activity_date' => '2026-10-05',
                'category_id' => Category::where('slug', 'workshop')->value('id'),
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACT-002',
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability dan testing.',
                'activity_date' => '2026-10-12',
                'category_id' => Category::where('slug', 'seminar')->value('id'),
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACT-003',
                'title' => 'Latihan Routing Laravel',
                'description' => 'Praktik membuat route dan controller.',
                'activity_date' => '2026-09-25',
                'category_id' => Category::where('slug', 'praktikum')->value('id'),
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACT-004',
                'title' => 'Review Migration dan Eloquent',
                'description' => 'Mengulas struktur database dan model.',
                'activity_date' => '2026-09-18',
                'category_id' => Category::where('slug', 'praktikum')->value('id'),
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACT-005',
                'title' => 'Presentasi Checkpoint Modul 3',
                'description' => 'Menyampaikan hasil Activity Manager v1.',
                'activity_date' => '2026-10-20',
                'category_id' => Category::where('slug', 'presentasi')->value('id'),
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
