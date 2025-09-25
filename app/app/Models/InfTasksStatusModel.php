<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfTasksStatusModel extends Model 
{
    protected $table = 'inf_tasks_status';

    protected $fillable = [
        'uuid', 
        'updated_at',
        'created_at',
        'deleted_at',
        'description'
    ];
}
