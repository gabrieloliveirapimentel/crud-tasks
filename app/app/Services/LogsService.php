<?php

namespace App\Services;

use Carbon\Carbon;
use ErrorException;
use App\Models\LogsModel;
use Illuminate\Support\Str;

class LogsService
{
    public function getAll(?array $filters = null)
    {
        return (new LogsModel())->getAllLogs($filters);
    }

    public function getById(string $id)
    {
        $log = (new LogsModel())->getLogById($id);

        if (!$log) throw new ErrorException('Log não encontrado.');

        return $log;
    }

    public function create(array $data)
    {
        $data = [
            '_id'        => (string) Str::uuid(),
            'message'    => $data['message'] ?? '',
            'action'     => $data['action'] ?? '',
            'created_at' => Carbon::now()->toISOString(),
        ];
        return (new LogsModel())->createLog($data);
    }
}