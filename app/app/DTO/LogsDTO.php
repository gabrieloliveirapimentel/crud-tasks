<?php

namespace App\DTO;


class LogsDTO extends DTO
{
    protected function set()
    {
        return [
            'id'            => $this->dto['_id'] ?? null,
            'action'        => $this->dto['action'] ?? null,
            'message'       => $this->dto['message'] ?? null,
            'oldData'       => $this->dto['action'] === 'PUT' ? [
                'title'       => $this->dto['old_data']['title'] ?? null,
                'description' => $this->dto['old_data']['description'] ?? null,
                'idStatus'    => $this->dto['old_data']['id_status'] ?? null,
            ] : null,
            'newData'       => $this->dto['action'] === 'PUT' ? [
                'title'       => $this->dto['new_data']['title'] ?? null,
                'description' => $this->dto['new_data']['description'] ?? null,
                'idStatus'    => $this->dto['new_data']['id_status'] ?? null,
            ] : null,
            'createdAt'     => $this->dto['created_at'] ?? null
        ];
    }
}