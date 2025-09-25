<?php

namespace App\DTO;

use App\Helpers\Utils;

class TasksDTO extends DTO
{
    protected function set()
    {
        return [
            'id'           => (int) $this->dto['id'] ?? null,
            'uuid'         => (string) $this->dto['uuid'] ?? null,
            'title'        => $this->dto['title'] ?? null,
            'description'  => $this->dto['description'] ?? null,
            'status'       => $this->dto['status'] ?? null,
            'updatedAt'    => Utils::formatDate($this->dto['updated_at']) ?? null,
            'createdAt'    => Utils::formatDate($this->dto['created_at']) ?? null 
        ];
    }
}