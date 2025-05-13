<?php

return [
    /** Project Configurations */
    'project_refid'                 => env('PROJECT_REFID', ''),


    /** Database Connection Configurations */
    'conn_multimedia_ip'                 => env('CONN_MULTIMEDIA_IP', env('DB_HOST')),
    'conn_multimedia_pt'                 => env('CONN_MULTIMEDIA_PT', env('DB_PORT')),
    'conn_multimedia_db'                 => env('CONN_MULTIMEDIA_DB', env('DB_DATABASE')),
    'conn_multimedia_un'                 => env('CONN_MULTIMEDIA_UN', env('DB_USERNAME')),
    'conn_multimedia_pw'                 => env('CONN_MULTIMEDIA_PW', env('DB_PASSWORD')),

    /** Query parameters */
    'fetch_paginate_max'            => env('FETCH_PAGINATE_MAX', 25),
];
