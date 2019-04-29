<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => array(

        # Our primary database connection
        'mysql' => array(
            'driver' => 'mysql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ),

        # Our secondary database connection
        'mysql2' => array(
            'driver' => 'mysql',
            'host'      => env('DB2_HOST'),
            'port'      => env('DB2_PORT'),
            'database'  => env('DB2_DATABASE'),
            'username'  => env('DB2_USERNAME'),
            'password'  => env('DB2_PASSWORD'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ),
    ),
];