<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model 
{
    protected $table = 'reg_tasks';

    protected $fillable = [
        'uuid', 
        'updated_at',
        'created_at',
        'deleted_at',
        'title',
        'description',
        'id_status'
    ];

    public function getTaskById(int $id)
    {
        return $this->select([
                        'rt.id', 
                        'rt.uuid', 
                        'rt.title', 
                        'rt.description', 
                        'rt.created_at', 
                        'rt.updated_at', 
                        'its.description as status'
                    ])
                ->from('reg_tasks as rt')
                ->join('inf_tasks_status as its', 'rt.id_status', '=', 'its.id')
                ->where('rt.id', $id)
                ->where('rt.deleted_at', null)
                ->where('its.deleted_at', null)
                ->first();
    }

    public function getExistsTaskById(int $id)
    {
        return $this->select([
                        'rt.title', 
                        'rt.description', 
                        'its.description as status'
                    ])
                ->from('reg_tasks as rt')
                ->join('inf_tasks_status as its', 'rt.id_status', '=', 'its.id')
                ->where('rt.id', $id)
                ->where('rt.deleted_at', null)
                ->first();
    }

    public function getAllTasks()
    {
        return $this->select([
                'rt.id', 
                'rt.uuid', 
                'rt.title', 
                'rt.description', 
                'rt.created_at', 
                'rt.updated_at', 
                'its.description as status'
            ])
        ->from('reg_tasks as rt')
        ->join('inf_tasks_status as its', 'rt.id_status', '=', 'its.id')
        ->where('rt.deleted_at', null)
        ->where('its.deleted_at', null)
        ->get();
    }

    public function getAllTasksByFilters(array $filters)
    {
        $query = $this->select([
                    'rt.id', 
                    'rt.uuid', 
                    'rt.title', 
                    'rt.description', 
                    'rt.created_at', 
                    'rt.updated_at', 
                    'its.description as status'
                ])
            ->from('reg_tasks as rt')
            ->join('inf_tasks_status as its', 'rt.id_status', '=', 'its.id')
            ->where('rt.deleted_at', null)
            ->where('its.deleted_at', null);

        if (isset($filters['status'])) {
            $query->where('its.description', $filters['status']);
        }

        if (isset($filters['title'])) {
            $query->where('rt.title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['date'])) {
            $query->where('rt.created_at', 'like', '%' . date_format(date_create($filters['date']), 'Y-m-d') . '%');
        }

        return $query->get();
    }
}
