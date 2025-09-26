<?php

namespace App\Http\Controllers;

use App\DTO\LogsDTO;
use App\Services\LogsService;

use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class LogsController extends Controller
{
    private LogsService $service;

    public function __construct(LogsService $service)
    {
        $this->service = $service; 
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['_id']);

            $logs = $this->service->getAll($filters);
            $logsDTO = LogsDTO::getAll(Utils::formatBSONDocument($logs));
            
            return response()->json([
                'success' => true,
                'message' => 'Logs listados com sucesso!',
                'data'    => $logsDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar logs.',
            ], 500);
        }
    }

    public function getLogById(string $id) 
    {
        try {
            $log = $this->service->getById($id);
            $logDTO = LogsDTO::get((array) $log);

            return response()->json([
                'message' => 'Log encontrado com sucesso!',
                'data' => $logDTO
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}