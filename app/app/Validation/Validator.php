<?php

namespace App\Validation;

use Illuminate\Support\Facades\DB;

class Validator
{
    public static function generateRules(array $data, array $rules = [])
    {
        foreach ($rules as $fieldConfig) {
            $field = $fieldConfig['name'];
            $label = $fieldConfig['label'];
            $fieldRules = $fieldConfig['rule'];
            
            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && (!isset($data[$field]) || trim($data[$field]) === '')) {
                    throw new \InvalidArgumentException($label . ' é obrigatório.');
                } elseif ($rule === 'string' && isset($data[$field]) && !is_string($data[$field])) {
                    throw new \InvalidArgumentException($label . ' deve ser uma string.');
                } elseif (preg_match('/^max:(\d+)$/', $rule, $matches) && isset($data[$field]) && strlen($data[$field]) > (int)$matches[1]) {
                    throw new \InvalidArgumentException($label . ' deve ter no máximo ' . $matches[1] . ' caracteres.');
                } elseif (preg_match('/^min:(\d+)$/', $rule, $matches) && isset($data[$field]) && strlen($data[$field]) < (int)$matches[1]) {
                    throw new \InvalidArgumentException($label . ' deve ter no mínimo ' . $matches[1] . ' caracteres.');
                } elseif (preg_match('/^exists:([\w_]+):([\w_]+)$/', $rule, $matches) && isset($data[$field])) {
                    $table = $matches[1];
                    $column = $matches[2];
                    
                    $exists = DB::table($table)->where($column, $data[$field])->exists();
                    if (!$exists) throw new \InvalidArgumentException($label . ' não existente.');
                }
            }
        }
    }
}