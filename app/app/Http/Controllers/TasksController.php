<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

use App\DTO\TasksDTO;
use App\Services\TasksService;
use App\Services\LogsService;

class TasksController extends Controller
{
    private TasksService $service;

    public function __construct(TasksService $service)
    {
        $this->service = $service;
    }
    
    public function getAllTasks(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['status', 'title', 'date']);

            $data = $this->service->getAll($filters);
            $taskDTO = TasksDTO::getAll($data->toArray());

            return response()->json([
                'message' => 'Tarefas listadas com sucesso!',
                'data'    => $taskDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar tarefas.',
            ], 500);
        }
    }

    public function getTasksById(int $id): JsonResponse
    {
        try {
            $task = $this->service->getById($id);

            $taskDTO = TasksDTO::get($task->toArray());
            return response()->json([
                'message' => 'Tarefa encontrada com sucesso!',
                'data'    => $taskDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar tarefa.',
            ], 500);
        }
    }

    public function createTask(Request $request): JsonResponse
    {
        try {
            $data = $request->only(['status', 'description', 'title']);
            $this->service->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Tarefa criada com sucesso!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateTask(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->only(['status', 'description', 'title']);
            $this->service->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Tarefa atualizada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTask(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Tarefa deletada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
