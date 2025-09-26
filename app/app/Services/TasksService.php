<?php

namespace App\Services;

use ErrorException;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\TasksModel;
use App\Validation\TasksValidator;
use App\Models\InfTasksStatusModel;

class TasksService
{
    private LogsService $logsService;
    private TasksValidator $validator;

    public function __construct(LogsService $logsService, TasksValidator $validator)
    {
        $this->validator = $validator;
        $this->logsService = $logsService;
    }

    public function getAll(array $filters = [])
    {
        return (new TasksModel())->getAllTasksByFilters($filters);
    }

    public function getById(int $id)
    {
        $task = (new TasksModel())->getTaskById($id);

        if (!$task)  throw new ErrorException('Tarefa não encontrada.');

        $this->logsService->logViewTask($id, $task->toArray());
        return $task;
    }

    public function create(array $data)
    {
        $this->validator->validate($data, 'CREATE');

        $data['uuid'] = Str::uuid();

        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) throw new ErrorException('Status não encontrado.');

        $data['id_status'] = $status['id'];
        unset($data['status']);

        $task = TasksModel::create($data);
        $this->logsService->logCreatedTask($task->id, $data);
    }

    public function update(int $id, array $data)
    {
        $this->validator->validate($data, 'UPDATE');

        $task = TasksModel::where('id', $id)->where('deleted_at', null)->first();
        $oldData = $task->toArray();

        if (!$task) throw new ErrorException('Tarefa não encontrada.');
        
        $status = InfTasksStatusModel::where('description', $data['status'])->where('deleted_at', null)->first();
        if (!$status) throw new ErrorException('Status não encontrado.');

        unset($data['status']);
        $data = [...$data, 'id_status' => $status['id'], 'updated_at' => Carbon::now()];

        $task->update($data);
        return $this->logsService->logUpdatedTask($id, $oldData, $data);
    }

    public function delete(int $id)
    {
        $task = TasksModel::where('id', $id)->first();
        if (!$task) throw new ErrorException('Tarefa não encontrada.');

        $task->update(['deleted_at' => Carbon::now()]);
        return $this->logsService->logDeletedTask($id, $task->toArray());
    }
}