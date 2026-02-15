<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Octane Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Laravel Octane runtime
    |
    */

    'server' => env('OCTANE_SERVER', 'swoole'),

    'host' => env('OCTANE_HOST', '127.0.0.1'),

    'port' => env('OCTANE_PORT', 8000),

    'workers' => env('OCTANE_WORKERS', 'auto'),

    'max_requests' => env('OCTANE_MAX_REQUESTS', 500),

    'memory_limit' => env('OCTANE_MEMORY_LIMIT', '128'),

    'timeout' => env('OCTANE_TIMEOUT', 30),

    'tick_frequency' => env('OCTANE_TICK_FREQUENCY', 500),

    'watch' => [
        'app',
        'bootstrap',
        'config',
        'database',
        'routes',
        'storage/app',
    ],

    'listeners' => [
        // \App\Listeners\...
    ],

    'middleware' => [
        'web' => [
            // Add custom middleware here
        ],
    ],

    'warm' => [
        // Cache warming services
    ],
];
