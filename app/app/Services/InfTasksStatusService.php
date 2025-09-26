<?php

namespace App\Services;

use ErrorException;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\InfTasksStatusModel;
use App\Validation\InfTasksStatusValidator;

class InfTasksStatusService
{
    public function getAll()
    {
        return InfTasksStatusModel::where('deleted_at', null)->get();
    }

    public function getById(int $id)
    {
        $status = InfTasksStatusModel::where('id', $id)->where('deleted_at', null)->first();

        if (!$status) throw new ErrorException('Status não encontrado.');

        return $status;
    }

    public function create(array $data)
    {
        (new InfTasksStatusValidator())->validate($data, 'CREATE');

        $data['uuid'] = Str::uuid();
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        
        return InfTasksStatusModel::create($data);
    }

    public function update(int $id, array $data)
    {
        (new InfTasksStatusValidator())->validate($data, 'UPDATE');
        
        $status = InfTasksStatusModel::where('id', $id)
            ->where('deleted_at', null)
            ->first();

        if (!$status) throw new ErrorException('Status não encontrado.');

        $data['updated_at'] = Carbon::now();
        return $status->update($data);
    }

    public function delete(int $id)
    {
        $status = InfTasksStatusModel::where('id', $id)->where('deleted_at', null)->first();
        
        if (!$status) throw new ErrorException('Status não encontrado.');

        return $status->update(['deleted_at' => Carbon::now()]);
    }
}