<?php


return [
    'title' => 'Rollen',
    'create'    => [
        'title' => 'Rol toevoegen'
    ],
    'table' => [
        'name'  => 'Naam',
        'users' => 'Aantal gebruikers'
    ],
    'edit'  => [
        'title' => 'Rol bewerken',
        'form'  => [
            'name'          => 'Naam',
            'permissions'   => 'Permissies'
        ],
        'back_to_overview'  => 'Terug naar overzicht'
    ],
    'create'    => [
        'title' => 'Nieuwe rol',
        'form'  => [
            'name'  => 'Naam',
            'permissions'   => 'Permissies',
        ],
        'back_to_overview'  => 'Terug naar overzicht'
    ],
    'actions'   => [
        'created'   => 'Rol `:name` is aangemaakt',
        'updated'   => 'Rol `:name` is bijgewerkt',
        'deleted'   => 'Role is verwijderd'
    ]
];