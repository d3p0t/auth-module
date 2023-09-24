<?php


return [
    'title' => 'Gebruikers',
    'create'    => [
        'title' => 'Gebruiker toevoegen'
    ],
    'table' => [
        'name'      => 'Naam',
        'username'  => 'Gebruikersnaam',
        'email'     => 'e-mail',
        'role'      => 'Rol'
    ],
    'edit'  => [
        'title' => 'Gebruiker bewerken',
        'form'  => [
            'name'          => 'Naam',
            'username'      => 'Gebruikersnaam',
            'email'         => 'E-mail',
            'role'          => 'Rol'
        ],
        'back_to_overview'  => 'Terug naar overzicht'
    ],
    'create'    => [
        'title' => 'Nieuwe gebruiker',
        'form'  => [
            'name'          => 'Naam',
            'username'      => 'Gebruikersnaam',
            'email'         => 'E-mail',
            'role'          => 'Rol',
            'password'      => 'Wachtwoord'
        ],
        'back_to_overview'  => 'Terug naar overzicht'
    ],
    'actions'   => [
        'created'   => 'Gebruiker `:username` is aangemaakt',
        'updated'   => 'Gebruiker `:username` is bijgewerkt',
        'deleted'   => 'Gebruiker is verwijderd'
    ]
];