<?php

/*
|--------------------------------------------------------------------------
| Authentication Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/

return [
    'failed'   => 'Błędny login lub hasło.',
    'password' => 'Podane hasło jest nieprawidłowe.',
    'throttle' => 'Za dużo nieudanych prób logowania. Proszę spróbować za :seconds sekund.',

    'login' => [
        'email' => 'adres email',
        'password' => 'hasło',
        'title' => 'logowanie',
        'forgot-question' => 'nie pamiętasz hasła?',
        'remember-me' => 'zapamiętaj mnie',
        'you-are-logged-in' => 'zalogowano',
    ],
    'register' => [
        'title' => 'rejestracja nowego konta',
        'name' => 'imię i nazwisko',
        'email' => 'adres email',
        'password' => 'hasło', 
        'confirm-password' => 'powtórz hasło', 
    ],
    'verify' => [
        'title' => 'weryfikacja adresu email',
        'before-proceeding' => 'przed kontynuowaniem korzystania z serwisu musisz zweryfikować swój email klikając w link w wiadomości, którą do Ciebie wysłaliśmy.',
        'if-didnt-receive-email' => 'jeśli nie masz żadnej wiadomości od nas',
        'fresh-email-sent' => 'Wysłano nową wiadomość email',
    ],
    'reset' => [
        'title' => 'reset hasła',
        'email' => 'adres email',
        'password' => 'hasło',
        'confirm-password' => 'powtórz hasło',
    ],
    'buttons' => [
        'login' => 'zaloguj',
        'register' => 'zarejestruj',
        'logout' => 'wyloguj',
        'resent' => 'wyślij prośbę o email weryfikacyjny',
        'send-verification-link' => 'wyślij link weryfikacyjny',
        'reset-password' => 'zmień hasło',
    ],
];
