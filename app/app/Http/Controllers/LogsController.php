<?php

namespace App\Http\Controllers;

use App\DTO\LogsDTO;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use App\Services\LogsService;
use Laravel\Lumen\Routing\Controller;

class LogsController extends Controller
{
    public function getAll(Request $request) {
        $service = app()->make(LogsService::class);
        $filters = $request->only(['_id']);

        $logs = $service->getAll($filters);
        $logsDTO = LogsDTO::getAll(Utils::formatBSONDocument($logs));
        return response()->json([
            'message' => 'Logs listados com sucesso!',
            'data' => $logsDTO
        ]);
    }

    public function getLogById(string $id) {
        $service = app()->make(LogsService::class);
        $log = $service->getById($id);

        if (!$log) {
            return response()->json([
                'message' => 'Log não encontrado!'
            ], 404);
        }

        $log = LogsDTO::get((array) $log);
        return response()->json([
            'message' => 'Log encontrado com sucesso!',
            'data' => $log
        ]);
    }
}