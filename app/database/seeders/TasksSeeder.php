<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TasksSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reg_tasks')->insert([
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'title' => 'Tarefa 1',
                'description' => 'Descrição da Tarefa 1',
                'id_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'title' => 'Tarefa 2',
                'description' => 'Descrição da Tarefa 2',
                'id_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'title' => 'Tarefa 3',
                'description' => 'Descrição da Tarefa 3',
                'id_status' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => DB::raw('gen_random_uuid()'),
                'title' => 'Tarefa 4',
                'description' => 'Descrição da Tarefa 4',
                'id_status' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
