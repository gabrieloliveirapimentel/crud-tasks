<?php

namespace App\Http\Controllers;

use App\DTO\InfTasksStatusDTO;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\InfTasksStatusService;

class InfTasksStatusController extends Controller
{
    public function getAllStatus()
    {
        $service = app()->make(InfTasksStatusService::class);
        $data = $service->getAll();

        $statusDTO = InfTasksStatusDTO::getAll($data->toArray());
        return response()->json([
            'message' => 'Status listados com sucesso!',
            'data' => $statusDTO
        ]);
    }

    public function getStatusByUuid(string $uuid)
    {
        $service = app()->make(InfTasksStatusService::class);
        $status = $service->getByUuid($uuid);

        if (!$status) {
            return response()->json([
                'message' => 'Status não encontrado.'
            ], 404);
        }

        $statusDTO = InfTasksStatusDTO::get($status->toArray());
        return response()->json([
            'message' => 'Status encontrado com sucesso!',
            'data'    => $statusDTO
        ]);

    }

    public function createStatus(Request $request)
    {
        $service = app()->make(InfTasksStatusService::class);
        $data = $request->only(['description']);

        $status = $service->create($data);
        $statusDTO = InfTasksStatusDTO::get($status->toArray());

        return response()->json([
            'message' => 'Status criado com sucesso!',
            'data'    => $statusDTO['uuid']
        ]);
    }

    public function updateStatus(Request $request, string $uuid)
    {
        $service = app()->make(InfTasksStatusService::class);
        $data = $request->only(['description']);

        $statusUpdated = $service->update($uuid, $data);
        if ($statusUpdated) {
            return response()->json([
                'message' => 'Status atualizado com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Status não encontrado.'
            ], 404);
        }
    }

    public function deleteStatus(string $uuid)
    {
        $service = app()->make(InfTasksStatusService::class);
        $statusDeleted = $service->delete($uuid);

        if ($statusDeleted) {
            return response()->json([
                'message' => 'Status deletado com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Status não encontrado.'
            ], 404);
        }
    }
}
