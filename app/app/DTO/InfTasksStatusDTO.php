<?php

namespace App\DTO;

class InfTasksStatusDTO extends DTO
{
    protected function set()
    {
        return [
            'id'           => (int) $this->dto['id'] ?? null,
            'uuid'         => (string) $this->dto['uuid'] ?? null,
            'description'  => $this->dto['description'] ?? null,
            'updatedAt'    => $this->dto['updated_at'] ?? null,
            'createdAt'    => $this->dto['created_at'] ?? null 
        ];
    }
}