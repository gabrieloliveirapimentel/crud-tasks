<?php

namespace App\DTO;

abstract class DTO
{
  protected $dto;

  public function __construct($dto)
  {
    $this->dto = $dto;
  }

  abstract protected function set();

  public static function get(array $row)
  {
    return (new static($row))->set();
  }

  public static function getAll(array $rows)
  {
    $map = array_map(function ($row) {
      return self::get($row);
    }, $rows);

    $map = array_filter($map);
    return array_values($map);
  }
}
