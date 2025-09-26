<?php

namespace App\DTO;


class LogsDTO extends DTO
{
    protected function set()
    {
        return [
            'id'           => $this->dto['_id'] ?? null,
            'action'       => $this->dto['action'] ?? null,
            'message'      => $this->dto['message'] ?? null
        ];
    }
}