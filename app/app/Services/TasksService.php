<?php

namespace App\Services;

use App\Helpers\Utils;
use App\Models\InfTasksStatusModel;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\TasksModel;

class TasksService
{
    public function getAll($filters)
    {
        if ($filters) {
            return (new TasksModel())->getAllTasksByFilters($filters);
        }

        return (new TasksModel())->getAllTasks();
    }

    public function getByUuid(string $uuid)
    {
        if (!Utils::isValidUuid($uuid)) return null;
        $task = (new TasksModel())->getTaskByUuid($uuid);

        if (!$task) return null;
        return $task;
    }

    public function getById(int $id)
    {
        return TasksModel::where('id', $id)->where('deleted_at', null)->first();
    }

    public function create(array $data)
    {
        $data['uuid'] = Str::uuid();

        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) return false;

        $data['id_status'] = $status['id'];
        unset($data['status']);

        return TasksModel::create($data);
    }

    public function update(string $uuid, array $data)
    {
        if (!Utils::isValidUuid($uuid)) return false;

        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) return false;

        $task = TasksModel::where('uuid', $uuid)->where('deleted_at', null)->first();
        if (!$task) return false;

        unset($data['status']);
        $data = [...$data, 'id_status' => $status['id'], 'updated_at' => Carbon::now()];
        $task = TasksModel::where('uuid', $uuid)->first();

        if ($task) {
            $task->update($data);
            return true;
        }
        return false;
    }

    public function delete(string $uuid)
    {
        if (!Utils::isValidUuid($uuid)) return false;

        $status = TasksModel::where('uuid', $uuid)->first();
        if ($status) {
            $status->update(['deleted_at' => Carbon::now()]);
            return true;
        }

        return false;
    }
}