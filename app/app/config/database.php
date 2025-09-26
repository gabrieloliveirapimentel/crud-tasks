<?php

return [
    'default' => env('DB_CONNECTION', 'pgsql'),

    'connections' => [
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', 'db'),
            'port'     => env('DB_PORT', 5432),
            'database' => env('DB_DATABASE', 'postgres_schema'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root123'),
        ],

        'mongo_db' => [
            'driver'   => 'mongodb',
            'host'     => env('MONGO_DB_HOST', 'mongo_db'),
            'port'     => env('MONGO_DB_PORT', 27017),
            'database' => env('MONGO_DB_DATABASE', 'mongo_schema'),
            'username' => env('MONGO_DB_USERNAME', 'root'),
            'password' => env('MONGO_DB_PASSWORD', 'root123'),
            'options'  => [
                'database' => env('MONGO_DB_AUTH_DB', 'admin')
            ],
        ],
    ],
];
