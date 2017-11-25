<?php

return [

    // Palavras em Nível Global da Aplicação
    'password' => 'Password',
    'email' => 'E-mail',
    'register' => 'Register',
    'login' => 'Login',
    'logout' => 'Logout',
    'cenario_padrao' => 'Default Scenario',
    'voltar' => 'Go Back',
    'alterar' => 'Change',
    'confirmar-exclusao' => 'Confirm Delete',
    'sair' => 'Exit',
    'descricao' => 'Description',
    'nome' => 'Name',
    'excluir' => 'Delete',

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
        ],
    ],

    'navegacao' =>
    [
        'projetos' => 'Projects',
        'sobre' => 'About',
        'atividades' => 'Activities',
        'recursos' => 'Resources',
        'cenarios' => 'Scenarios',
        'gerenciar-dependencias' => 'Manage Dependencies',

        'descricoes' =>
        [
            'projetos' => 'Manage your projects.',
            'atividades' => 'Manage your activities.',
            'recursos' => 'Manage your resources.',
            'cenarios' => 'Manage your project\'s scenarios.',
            'gerenciar-dependencias' => 'Manage the activities\' dependencies of a given scenario.',
        ],
    ],

    // views/projetos
    'projetos' =>
    [
        // views/projetos/index.blade.php
        'index' =>
        [
            'flash-messages' =>
            [
                'compartilhar-sucesso' => 'Project was shared successfully!',
                'compartilhar-erro' => 'Something is wrong! Please, try again.',
                'projeto-criado-sucesso' => 'Project was created sucessfully!',
                'projeto-alterado-sucesso' => 'Project was changed successfully!',
                'projeto-excluido-sucesso' => 'Project was deleted successfully with all related activities and resources.',
                'compartilhar-emails-ausentes' => 'Type in user(s) e-mail(s) with whom you want to share this project.',
                'compartilhar-usuario-inexistente' => 'It was not possible to share this project with the following user|It was not possible to share this project with the following users',
                'compartilhar-verificar-email' => 'Check the e-mail typed-in.|Check the e-mails typed-in.',
                'compartilhar-usuarios-com-acesso' => 'The following user already has access to this project|The following users already have access to this project',
            ],

            'botoes' =>
            [
                'criar' => 'Create Project',
                'compartilhar' => 'Share',
                'editar' => 'Edit',
                'excluir' => 'Delete',
            ],
        ],

        // views/projetos/edit.blade.php
        'edit' =>
        [
            'projeto' => 'Project:',
            'descricao' => 'Description:',
        ],

        // views/projetos/confirm-delete.blade.php
        'confirm-delete' =>
        [
            'deseja-excluir' => 'Are you sure you want to delete permanently the project below?',
        ],

        // views/layouts/partials/compartilhar-projeto.blade.php
        'modal-compartilhar' =>
        [
            'compartilhar-projeto' => 'Share Project',
            'digite-emails' => 'Type in the user(s) e-mail(s) that you want to share this project separated by semicolon (&semi;).',
            'projeto' => 'Project:',
            'placeholder-emails' => 'Type in the e-mail(s) separated by semicolon (&semi;) here.',
        ],

        'show' =>
        [
            'atividades' => 'Activities',
            'cenarios' => 'Scenarios',
            'recursos' => 'Resources',

            'descricoes' =>
            [
                'atividades' => 'Click here to see more activities.',
                'recursos' => 'Click here to see more resources.',
                'cenarios' => 'Click here to see more scenarios.',
            ],
        ],
    ],

    'atividades' =>
    [
        'index' =>
        [
            'criar-atividade' => 'Create Activity',
            'sem-atividades' => 'There\'s no activity registered.',
        ],

        'confirm-delete' =>
        [
            'deseja-excluir' => 'Are you sure you want to delete permanently the activity below?',
            'excluir' => 'Delete Activity',
        ],
    ],

    'tabelas' =>
    [
        'projeto' => 'Project',
        'autoria' => 'Ownership',
        'criado-em' => 'Created At',
        'acoes' => 'Actions',
        'atividades' => 'Activities',
        'descricao' => 'Description',
        'editar' => 'Edit',
        'excluir' => 'Delete',
    ],
];