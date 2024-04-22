<?php

return [
    'organization' => 'organizacja',
    'organizations' => 'organizacje',
    'add' => 'dodaj organizację',
    'save' => 'zapisz',
    'name' => 'nazwa',
    'prefix' => 'prefix',
    'card' => 'karta organizacji',
    'quizes' => 'quizy',
    'members' => [
        'members' => 'członkowie',
        'none' => 'brak',
        'add' => [
            'manager' => 'dodaj menadżera',
            'trainer' => 'dodaj trenera'
        ],
    ],
    'show' => 'podgląd',
    'edit' => 'edycja',
    'options' => 'opcje',
    'scenarios' => [
        'scenarios' => 'scenariusze',
        'none' => 'brak',
        'add' => 'dodaj scenariusz',
        'add-new' => 'stwórz nowy',
        'add-listed' => 'wybierz z listy',
    ],
    'headset' =>[
        'login' => 'login gogli',
        'pin' => 'pin gogli'
    ],
    'expires_at' => 'data ważności',
    'logo' => [
        'drop' => 'Wybierz z dysku lub upuść logo dla organiacji. (rozmiar do 5MB, wymiary do 1024 x 1024)',
        'logo' => 'logo'
         ],
    'create' => 'utwórz',
    'placeholder' => [
        'name' => 'podaj nazwę organizacji',
        'prefix' => 'podaj prefix orgnizacji',
        'headset_login' => 'podaj login dla gogli',
        'headset_pin' => 'podaj pin dla gogli',
    ],
    'message' => [
        'remove-member' => [
            'fail' => [
                'title' => 'Błąd!',
                'no-admin' => 'Nie można usunąć użytkownika, kiedy nie ma administratora organizacji.',
                'non-organization-member' => 'To nie jest członek tej organizacji.',
                'no-permission' => 'Nie masz uprawnień do tej operacji.',
            ],
            'success' => [
                'title' => 'Wykonano!',
                'trainer' => 'Trener zostł usunięty z organizacji.',
                'manager' => 'Manager został usunięty z organizacji.',
                'admin' => 'Administrator organizacji został usuniety.'
            ]
        ]
    ],        
];