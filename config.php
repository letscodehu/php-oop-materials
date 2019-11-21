<?php 

return [
    'db_host' => 'localhost',
    'db_name' => 'training',
    'db_user' => 'training',
    'db_pass' => 'password',
    'session' => [
        'driver' => 'file',
        'config' => [
            'folder' => realpath(__DIR__)."/storage/sessions"
        ]
    ]
];