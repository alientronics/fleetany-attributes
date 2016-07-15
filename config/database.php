<?php

return [

    'default' => 'mysql',

    'connections' => [

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('DB_HOST', 'localhost'),
            'port'     => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE', 'alientronics'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'options' => [
                'database' => 'alientronics' // sets the authentication database required by mongo 3
            ]
        ],
        
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'alientronics'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
            'prefix'    => env('DB_PREFIX', ''),
            'timezone'  => env('DB_TIMEZONE', '+00:00'),
            'strict'    => env('DB_STRICT_MODE', false),
        ],
        
        'dynamodb' => [
            'key'      => env('DYNAMODB_KEY', 'dynamodb_local'),
            'secret'   => env('DYNAMODB_SECRET', 'secret'),
            'region'   => env('DYNAMODB_REGION', 'eu-central-1'),
            'version'  => env('DYNAMODB_VERSION', 'latest'),
            'endpoint' => env('DYNAMODB_LOCAL_ENDPOINT', 'http://localhost:8000'),
        ],

    ],

    'migrations' => 'migrations',
];
