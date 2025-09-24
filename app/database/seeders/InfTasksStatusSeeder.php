<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InfTasksStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inf_tasks_status')->insert([
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'description' => 'Em andamento',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'description' => 'Concluída',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'description' => 'Finalizada',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
