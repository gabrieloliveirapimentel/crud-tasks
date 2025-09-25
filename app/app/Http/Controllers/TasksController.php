<?php

namespace App\Http\Controllers;

use App\DTO\InfTasksStatusDTO;
use App\DTO\TasksDTO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\TasksService;

class TasksController extends Controller
{
    public function getAllTasks(Request $request)
    {
        $service = app()->make(TasksService::class);
        $filters = $request->only(['status', 'title', 'date']);

        $data = $service->getAll($filters);
        $taskDTO = TasksDTO::getAll($data->toArray());
        return response()->json([
            'message' => 'Tarefas listadas com sucesso!',
            'data' => $taskDTO
        ]);
    }

    public function getTasksByUuid(string $uuid)
    {
        $service = app()->make(TasksService::class);
        $task = $service->getByUuid($uuid);

        if (!$task) {
            return response()->json([
                'message' => 'Tarefa não encontrada.'
            ], 404);
        }

        $taskDTO = TasksDTO::get($task->toArray());
        return response()->json([
            'message' => 'Tarefa encontrada com sucesso!',
            'data'    => $taskDTO
        ]);

    }

    public function createTask(Request $request)
    {
        $service = app()->make(TasksService::class);
        $data = $request->only(['status', 'description', 'title']);

        $task = $service->create($data);
        if (!$task) {
            return response()->json([
                'message' => 'Status informado não existe.'
            ], 400);
        }

        $taskDTO = InfTasksStatusDTO::get($task->toArray());

        return response()->json([
            'message' => 'Tarefa criada com sucesso!',
            'data'    => $taskDTO['uuid']
        ]);
    }

    public function updateTask(Request $request, string $uuid)
    {
        $service = app()->make(TasksService::class);
        $data = $request->only(['status', 'description', 'title']);

        $taskUpdated = $service->update($uuid, $data);
        if ($taskUpdated) {
            return response()->json([
                'message' => 'Tarefa atualizada com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Não foi possível atualizar a tarefa.'
            ], 404);
        }
    }

    public function deleteTask(string $uuid)
    {
        $service = app()->make(TasksService::class);
        $taskDeleted = $service->delete($uuid);

        if ($taskDeleted) {
            return response()->json([
                'message' => 'Tarefa deletada com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Tarefa não encontrada.'
            ], 404);
        }
    }
}
