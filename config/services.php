<?php 

return [
    'dynamodb' => [
        'key'      => env('DYNAMODB_KEY', 'dynamodb_local'),
        'secret'   => env('DYNAMODB_SECRET', 'secret'),
        'region'   => env('DYNAMODB_REGION', 'eu-central-1'),
        'version'  => env('DYNAMODB_VERSION', 'latest'),
        'endpoint' => env('DYNAMODB_LOCAL_ENDPOINT', 'http://localhost:8001'),
        'credentials' => [
            'key' => 'not-a-real-key',
            'secret' => 'not-a-real-secret',
        ],
    ]
];