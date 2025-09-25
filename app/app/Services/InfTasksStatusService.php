<?php

namespace App\Services;

use App\Helpers\Utils;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\InfTasksStatusModel;

class InfTasksStatusService
{
    public function getAll()
    {
        return InfTasksStatusModel::where('deleted_at', null)->get();
    }

    public function getByUuid(string $uuid)
    {
        if (!Utils::isValidUuid($uuid)) return null;
        return InfTasksStatusModel::where('uuid', $uuid)->where('deleted_at', null)->first();
    }

    public function getById(int $id)
    {
        return InfTasksStatusModel::where('id', $id)->where('deleted_at', null)->first();
    }

    public function create(array $data)
    {
        $data['uuid'] = Str::uuid();
        return InfTasksStatusModel::create($data);
    }

    public function update(string $uuid, array $data)
    {
        if (!Utils::isValidUuid($uuid)) return false;

        $data = [...$data, 'updated_at' => Carbon::now()];
        $status = InfTasksStatusModel::where('uuid', $uuid)->first();

        if ($status) {
            $status->update($data);
            return true;
        }
        return false;
    }

    public function delete(string $uuid)
    {
        if (!Utils::isValidUuid($uuid)) return false;

        $status = InfTasksStatusModel::where('uuid', $uuid)->first();
        if ($status) {
            $status->update(['deleted_at' => Carbon::now()]);
            return true;
        }

        return false;
    }
}