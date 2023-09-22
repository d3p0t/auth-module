<?php

return [
    'name' => 'Auth',
    'menu_items'    => [
        [
            'label'         => 'Users',
            'route'         => '/admin/auth/users',
            'permissions'   => []
        ],
        [
            'label'         => 'Roles',
            'route'         => '/admin/auth/roles',
            'permissions'   => ['view roles']
        ],

    ]
];
