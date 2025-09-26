<?php

namespace App\Services;

use App\Helpers\Utils;
use App\Models\InfTasksStatusModel;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\TasksModel;

class TasksService
{
    public function getAll(array $filters)
    {
        return (new TasksModel())->getAllTasksByFilters($filters);
    }

    public function getById(int $id)
    {
        $task = (new TasksModel())->getTaskById($id);

        if (!$task) {
            (new LogsService())->create([
                'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} não encontrada.",
                'action' => 'GET'
            ]);
            return null;
        }

        (new LogsService())->create([
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} encontrada.",
            'action' => 'GET'
        ]);
        return $task;
    }

    public function create(array $data)
    {
        $data['uuid'] = Str::uuid();

        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) {
            (new LogsService())->create([
                'message' => "[" . Utils::formatDate(Carbon::now()) . "] Status '{$data['status']}' não encontrado ao criar tarefa.",
                'action' => 'CREATE'
            ]);
            return false;
        }

        $data['id_status'] = $status['id'];
        unset($data['status']);

        (new LogsService())->create([
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa '{$data['title']}' criada com sucesso.",
            'action' => 'CREATE'
        ]);
        return TasksModel::create($data);
    }

    public function update(int $id, array $data)
    {
        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) {
            (new LogsService())->create([
                'message' => "[" . Utils::formatDate(Carbon::now()) . "] Status '{$data['status']}' não encontrado ao atualizar tarefa.",
                'action' => 'UPDATE'
            ]);
            return false;
        }

        $task = TasksModel::where('id', $id)->where('deleted_at', null)->first();
        if (!$task) {
            (new LogsService())->create([
                'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} não encontrada ao atualizar.",
                'action' => 'UPDATE'
            ]);
            return false;
        }

        unset($data['status']);
        $data = [...$data, 'id_status' => $status['id'], 'updated_at' => Carbon::now()];

        $task->update($data);
        (new LogsService())->create([
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} atualizada com sucesso.",
            'action' => 'UPDATE'
        ]);
        return true;
    }

    public function delete(int $id)
    {
        $task = TasksModel::where('id', $id)->first();
        if ($task) {
            $task->update(['deleted_at' => Carbon::now()]);
            (new LogsService())->create([
                'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} deletada com sucesso.",
                'action' => 'DELETE'
            ]);
            return true;
        }

        (new LogsService())->create([
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa com ID {$id} não encontrada ao deletar.",
            'action' => 'DELETE'
        ]);
        return false;
    }
}