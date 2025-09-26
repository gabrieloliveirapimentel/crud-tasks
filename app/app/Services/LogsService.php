<?php

namespace App\Services;

use App\Models\LogsModel;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogsService
{
    public function getAll(?array $filters = null)
    {
        return (new LogsModel())->getAllLogs($filters);
    }

    public function getById(string $id)
    {
        return (new LogsModel())->getLogById($id);
    }

    public function create(array $data)
    {
        $data = [
            '_id' => (string) Str::uuid(),
            'message' => $data['message'] ?? '',
            'action' => $data['action'] ?? '',
            'created_at' => Carbon::now()->toISOString(),
        ];
        return (new LogsModel())->createLog($data);
    }
}