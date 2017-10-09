<?php

return [

    // Palavras em Nível Global da Aplicação
    'password' => 'Senha',
    'email' => 'E-mail',
    'register' => 'Cadastrar',
    'login' => 'Acessar',
    'logout' => 'Sair',

    // views/auth/
    'auth' =>
    [
        // views/auth/register.blade.php
        'register' =>
        [
            'password' => 'Senha',
            'confirm_password' => 'Confirmar Senha',
            'email_address' => 'E-mail',
            'name' => 'Nome',
            'register' => 'Cadastrar',
        ],

        // views/auth/login.blade.php
        'login' =>
        [
            'forgot_password' => 'Esqueceu a Senha?',
            'remember_me' => 'Lembrar-me'
        ],

        // views/auth/passwords
        'passwords' =>
        [
            // views/auth/passwords/email.blade.php
            'email' =>
            [
                'reset_password' => 'Redefinir Senha',
                'send_password_reset_link' => 'Enviar Link de Redefinição de Senha',
            ],

            // views/auth/passwords/reset.blade.php
            'reset' =>
            [
                'reset_password' => 'Redefinir Senha',
                'confirm_password' => 'Confirmar Senha',
            ]
        ]
    ],
];