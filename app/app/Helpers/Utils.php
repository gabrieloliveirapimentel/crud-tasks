<?php

namespace App\Helpers;

class Utils
{
    public static function isValidUuid(string $uuid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid);
    }

    public static function formatDate($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}