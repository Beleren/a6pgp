<?php

return [

    // Palavras em Nível Global da Aplicação
    'password' => 'Password',
    'email' => 'E-mail',
    'register' => 'Register',
    'login' => 'Login',
    'logout' => 'Logout',

    // views/auth/
    'auth' =>
    [
        // views/auth/register.blade.php
        'register' =>
        [
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'email_address' => 'E-mail',
            'name' => 'Name',
            'register' => 'Register',
        ],

        // views/auth/login.blade.php
        'login' =>
        [
            'forgot_password' => 'Forgot Password?',
            'remember_me' => 'Remember me'
        ],

        // views/auth/passwords
        'passwords' =>
        [
            // views/auth/passwords/email.blade.php
            'email' =>
            [
                'reset_password' => 'Reset Password',
                'send_password_reset_link' => 'Send Password Reset Link',
            ],

            // views/auth/passwords/reset.blade.php
            'reset' =>
            [
                'reset_password' => 'Reset Password',
                'confirm_password' => 'Confirm Password',
            ]
        ]
    ],
];