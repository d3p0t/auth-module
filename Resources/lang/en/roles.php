<?php


return [
    'title' => 'Roles',
    'create'    => [
        'title' => 'Create Role'
    ],
    'table' => [
        'name'  => 'Name',
        'users' => '# of Users'
    ],
    'edit'  => [
        'title' => 'Edit Role',
        'form'  => [
            'name'          => 'Name',
            'permissions'   => 'Permissions'
        ],
        'back_to_overview'  => 'Back to overview'
    ],
    'actions'   => [
        'created'   => 'Role `:name` has been created',
        'updated'   => 'Role `:name` has been updated',
        'deleted'   => 'Role has been deleted'
    ]
];