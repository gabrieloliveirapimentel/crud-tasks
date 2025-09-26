<?php

namespace App\Http\Controllers;

use App\DTO\InfTasksStatusDTO;
use App\Services\InfTasksStatusService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class InfTasksStatusController extends Controller
{
    private InfTasksStatusService $service;

    public function __construct(InfTasksStatusService $service)
    {
        $this->service = $service; 
    }

    public function getAllStatus(): JsonResponse
    {
        try {
            $data = $this->service->getAll();
            $statusDTO = InfTasksStatusDTO::getAll($data->toArray());
            
            return response()->json([
                'message' => 'Status listados com sucesso!',
                'data' => $statusDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar status.',
            ], 500);
        }
    }

    public function getStatusById(int $id): JsonResponse
    {
        try {
            $status = $this->service->getById($id);
            $statusDTO = InfTasksStatusDTO::get($status->toArray());

            return response()->json([
                'message' => 'Status encontrado com sucesso!',
                'data' => $statusDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createStatus(Request $request): JsonResponse
    {
        try {
            $data = $request->only(['description']);
            $this->service->create($data);

            return response()->json([
                'message' => 'Status criado com sucesso!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->only(['description']);
            $this->service->update($id, $data);
            
            return response()->json([
                'success' => true,
                'message' => 'Status atualizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteStatus(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Status deletado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
