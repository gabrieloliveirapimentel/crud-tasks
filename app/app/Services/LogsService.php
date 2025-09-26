<?php

namespace App\Services;

use Carbon\Carbon;
use ErrorException;
use Illuminate\Support\Str;

use App\Helpers\Utils;
use App\Models\LogsModel;
class LogsService
{
    private LogsModel $logsModel;

    public function __construct()
    {
        $this->logsModel = new LogsModel();
    }

    public function getAll(?array $filters = null)
    {
        return $this->logsModel->getAllLogs($filters ?? []);
    }

    public function getById(string $id)
    {
        $log = $this->logsModel->getLogById($id);

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
        return $this->logsModel->createLog($data);
    }

    public function logCreatedTask(int $taskId, array $taskData)
    {
        $logData = [
            '_id' => (string) Str::uuid(),
            'action' => 'POST',
            'task_id' => $taskId,
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa '{$taskData['title']}' foi criada",
            'created_at' => Carbon::now()->toISOString()
        ];

        $this->logsModel->createLog($logData);
    }


    public function logUpdatedTask(int $taskId, array $oldData, array $newData)
    {
        $logData = [
            '_id' => (string) Str::uuid(),
            'action' => 'PUT',
            'task_id' => $taskId,
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa '{$newData['title']}' foi atualizada",
            'old_data' => $oldData,
            'new_data' => $newData,
            'created_at' => Carbon::now()->toISOString()
        ];

        $this->logsModel->createLog($logData);
    }

    public function logDeletedTask(int $taskId, array $taskData)
    {
        $logData = [
            '_id' => (string) Str::uuid(),
            'action' => 'DELETE',
            'task_id' => $taskId,
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa '{$taskData['title']}' foi deletada",
            'created_at' => Carbon::now()->toISOString()
        ];

        $this->logsModel->createLog($logData);
    }

    public function logViewTask(int $taskId, array $taskData)
    {
        $logData = [
            '_id' => (string) Str::uuid(),
            'action' => 'GET',
            'task_id' => $taskId,
            'message' => "[" . Utils::formatDate(Carbon::now()) . "] Tarefa '{$taskData['title']}' foi visualizada",
            'created_at' => Carbon::now()->toISOString()
        ];

        $this->logsModel->createLog($logData);
    }

    public function getLogsByTaskId(int $taskId)
    {
        return $this->logsModel->getAllLogs(['task_id' => $taskId]);
    }
}