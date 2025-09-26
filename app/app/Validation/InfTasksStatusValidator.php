<?php

namespace App\Validation;

class InfTasksStatusValidator extends Validator
{
    const INSERT_RULES = [
        [
            'label' => 'Descrição',
            'name' => 'description',
            'rule' => ['required', 'string', 'max:255', 'min:3'],
        ]
    ];

    const UPDATE_RULES = [
        [
            'label' => 'Descrição',
            'name' => 'description',
            'rule' => ['string', 'max:255', 'min:3'],
        ]
    ];
    
    public static function validate(array $data, string $rule)
    {
        switch ($rule) {
            case 'CREATE':
                self::generateRules($data, self::INSERT_RULES);
                break;
            case 'UPDATE':
                self::generateRules($data, self::UPDATE_RULES);
                break;
            default:
                self::generateRules($data, self::INSERT_RULES);
                break;
        }
    }
}