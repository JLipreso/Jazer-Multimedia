<?php

return [
    'database_connection' => [
        'driver'        => 'mysql',
        'host'          => env('CONN_MULTIMEDIA_IP', config('multimediasconfig.conn_multimedia_ip')),
        'port'          => env('CONN_MULTIMEDIA_PT', config('multimediasconfig.conn_multimedia_pt')),
        'database'      => env('CONN_MULTIMEDIA_DB', config('multimediasconfig.conn_multimedia_db')),
        'username'      => env('CONN_MULTIMEDIA_UN', config('multimediasconfig.conn_multimedia_un')),
        'password'      => env('CONN_MULTIMEDIA_PW', config('multimediasconfig.conn_multimedia_pw')),
        'charset'       => 'utf8mb4',
        'collation'     => 'utf8mb4_unicode_ci',
        'prefix'        => ''
    ],
];