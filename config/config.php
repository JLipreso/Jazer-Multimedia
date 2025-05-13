<?php

return [
    /** Project Configurations */
    'project_refid'                     => env('PROJECT_REFID', ''),

    /** FTP Account */
    'ftp_host'                          => env('FTP_MULTIMEDIA_HOST', env('FTP_HOST')),
    'ftp_ip'                            => env('FTP_MULTIMEDIA_IP', env('FTP_IP')),
    'ftp_username'                      => env('FTP_MULTIMEDIA_USERNAME', env('FTP_USERNAME')),
    'ftp_password'                      => env('FTP_MULTIMEDIA_PASSWORD', env('FTP_PASSWORD')),
    'ftp_directory'                     => env('FTP_MULTIMEDIA_DIRECTORY', env('FTP_DIRECTORY')),

    /** Database Connection Configurations */
    'conn_branches_ip'                 => env('CONN_BRANCHES_IP', env('DB_HOST')),
    'conn_branches_pt'                 => env('CONN_BRANCHES_PT', env('DB_PORT')),
    'conn_branches_db'                 => env('CONN_BRANCHES_DB', env('DB_DATABASE')),
    'conn_branches_un'                 => env('CONN_BRANCHES_UN', env('DB_USERNAME')),
    'conn_branches_pw'                 => env('CONN_BRANCHES_PW', env('DB_PASSWORD')),

    /** Query parameters */
    'fetch_paginate_max'            => env('FETCH_PAGINATE_MAX', 25),
];
