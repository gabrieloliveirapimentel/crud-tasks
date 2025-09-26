<?php

namespace App\Validation;

class TasksValidator extends Validator
{
    const INSERT_RULES = [
        [
            'label' => 'Descrição',
            'name' => 'description',
            'rule' => ['required', 'string', 'max:255', 'min:3'],
        ],
        [
            'label' => 'Título',
            'name' => 'title',
            'rule' => ['required', 'string', 'max:100', 'min:3'],
        ],
        [
            'label' => 'Status',
            'name' => 'status',
            'rule' => ['required', 'exists:inf_tasks_status:description'],
        ]
    ];

    const UPDATE_RULES = [
        [
            'label' => 'Descrição',
            'name' => 'description',
            'rule' => ['required', 'string', 'max:255', 'min:3'],
        ],
        [
            'label' => 'Título',
            'name' => 'title',
            'rule' => ['required', 'string', 'max:100', 'min:3'],
        ],
        [
            'label' => 'Status',
            'name' => 'status',
            'rule' => ['required', 'exists:inf_tasks_status:description'],
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


