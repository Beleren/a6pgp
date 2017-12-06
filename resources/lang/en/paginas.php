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
    'alterar' => 'Update',
    'confirmar-exclusao' => 'Confirm Delete',
    'sair' => 'Exit',
    'descricao' => 'Description',
    'nome' => 'Name',
    'excluir' => 'Delete',
    'sair' => 'Exit',
    'salvar' => 'Save',

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
                'projeto-alterado-sucesso' => 'Project was updated successfully!',
                'projeto-excluido-sucesso' => 'Project was deleted successfully with all related activities and resources.',
                'compartilhar-emails-ausentes' => 'Type in user(s) e-mail(s) with whom you want to share this project.',
                'compartilhar-usuario-inexistente' => 'It was not possible to share this project with the following user|It was not possible to share this project with the following users',
                'compartilhar-verificar-email' => 'Check the e-mail typed-in.|Check the e-mails typed-in.',
                'compartilhar-usuarios-com-acesso' => 'The following user already has access to this project|The following users already have access to this project',
                'proprio' => 'Own',
                'compartilhado' => 'Shared',
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
            'sem-atividades' => 'There\'s no activities registered.',
        ],

        'confirm-delete' =>
        [
            'deseja-excluir' => 'Are you sure you want to delete permanently the activity below?',
            'excluir' => 'Delete Activity',
        ],

        'atividade-criada-sucesso' => 'Activity was created successfully!',
        'atividade-alterada-sucesso' => 'Activity was updated successfully!',
        'atividade-excluida-sucesso' => 'Activity was deleted successfully with all its related dependencies!',
    ],

    'recursos' =>
    [
        'index' =>
        [
            'criar-recurso' => 'Create Resource',
            'tipo-recurso' => 'Resource Type',
            'custo-unitario' => 'Unit Cost',
            'custo-unico' => 'Single Cost',
            'sem-recursos' => 'There\'s no resources registered.',

            'tipos-recursos' =>
            [
                'humano' => 'Human',
                'fisico' => 'Physical',
                'financeiro' => 'Financial',
                'tecnologico' => 'Technological',
            ],
        ],

        'deseja-excluir' => 'Are you sure you want to delete permanently the resource below?',
        'recurso-criado' => 'Resource was created successfully!',
        'recurso-atualizado' => 'Resource was updated successfully!',
        'recurso-excluido' => 'Resource was deleted successfully with all its related dependencies!',
    ],

    'cenarios' =>
    [
        'criar-cenario' => 'Create Scenario',
        'data-criacao' => 'Creation Date',
        'visualizar-sequencias' => 'See Dependencies',
        'deseja-excluir' => 'Are you sure you want to delete permanently the scenario below?',
        'cenario-criado-sucesso' => 'Scenario was created successfully!',
        'cenario-atualizado' => 'Scenario was updated successfully!',
        'cenario-excluido' => 'Scenario was deleted successfully with its all related dependencies!',
        'cenario' => 'Scenario',
        'atividade' => 'Activity',
        'atividades-predecessoras' => 'Predecessor Activities',
        'recursos' => 'Resources',
        'atividades' => 'Activities',
        'recursos' => 'Resources',
        'sem-atividades' => 'There\'re no activities registered.',
        'sem-recursos' => 'There\'re no resources registered.',
        'nome' => 'Name',
        'data-inicio-projeto' => 'Project\'s Initial Date',
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
        'recurso' => 'Resource',
        'cenario' => 'Scenario',
        'data-inicio' => 'Project\'s Initial Date',
    ],

    'carousel' =>
    [
        'gerenciamento-projeto' => 'Smarter projects\' management with dynamic planning.',
        'foco-didatico' => 'Projects\' management with a more educational focus.',
        'open-source' => 'Upon giants\' shoulders of open source community.',
    ],

    'home' =>
    [
        'como-nasceu' => 'Besouro\'s project was born as an requirement for Project Management Practices (A6PGP in Portuguese Acronym) classes
        to conclude the course of Systems Analysis and Development Technology (TADS in Portuguese Acronym) of
        Instituto Federal de São Paulo (IFSP).',
        'objetivo-projeto' => 'The objective of this project is to provide an application that permits the planning of projects
        using Program Evaluation and Review Technique (PERT) and Critical Path Method (CPM). The features provided are:',
        'programacao-atividades' => 'Activity Programming',
        'construcao-rede' => 'Network Construction',
        'caminho-critico' => 'Critical Path Calculation',
        'importacao-exportacao-excel' => 'Excel\'s spreadsheets import and export',
        'disponivel-via-web' => 'System available for several platforms by means of web access',
    ],

    'sequencias' =>
    [
        'validacoes' =>
        [
            'detalhes' =>
            [
                'atividades' =>
                [
                    'duracao' =>
                    [
                        'integer' => 'Duration must be an numeric type.',
                        'min' => 'Duration must be greater than zero.',
                    ],
                    'requerRecursos.in' => 'Demands Resources must be true or false value.',
                    'inicioOtimista.date' => 'Optimistic Start must be a date format.',
                    'inicioPessimista.after_or_equal' => 'Pessimistic Start must be greater than or equal to today.',
                    'fimOtimista.date' => 'Optimistic End must be a date format.',
                    'fimPessimista.after_or_equal' => 'Pessimistic End must be greater than or equal to today.',
                ],

                'recursos' =>
                [
                    'qtd' =>
                    [
                        'numeric' => 'Amount must be an integer number.',
                        'min' => 'Amount must be greater than zero.',
                    ],

                    'dataDispRecurso.date' => 'Resource Availability Date is in an invalid format.',
                    'data.after' => 'Resource Availability Date must greater or equal to today.',

                    'tempoAlocado' =>
                    [
                        'timezone' => 'Allotted Time must be in a time format.',
                        'min' => 'Allotted Time must be positive.',
                    ],
                ],
            ],
        ],

        'salvar-cenario' => 'Save Scenario',
        'salvar-novo-cenario' => 'Save in New Scenario',
        'diagrama' => 'Diagram',
        'atividade' => 'Activity',
        'duracao' => 'Duration',
        'requer-recursos' => 'Demands Resources?',
        'inicio-otimista' => 'Optimistic Start',
        'inicio-pessimista' => 'Pessimistic Start',
        'fim-otimista' => 'Optimistic End',
        'fim-pessimista' => 'Pessimistic End',
        'quantidade-recurso' => 'Resource Quantity',
        'data-disp-recurso' => 'Resource Availability Date',
        'tempo-alocado' => 'Allotted Time',
    ],

    'registrar' =>
    [
        'name' =>
        [
            'required' => 'Name is required.',
            'string' => 'Name must be a string of characters.',
            'max' => 'Name must be less than 255 characteres.',
            'min' => 'Name must have at least 3 characters.',
        ],

        'email' =>
        [
            'required' => 'E-mail is required.',
            'string' => 'E-mail must be a string of characters.',
            'formato' => 'E-mail is in an invalid format.',
            'unique' => 'This e-mail is already in use.',
        ],

        'password' =>
        [
            'require' => 'Password is required.',
            'string' => 'Password must be a string of characters.',
            'min' => 'Password must have at least 6 characters.',
            'confirmed' => 'Password fields don\'t match.',
            'regex' => 'Type in a password with at least two lowercase letters, one uppercase letter and one special character.',
        ],
    ],

    'resultado' => [
        'atividade' => 'Activity',
        'duracao' => 'Duration',
        'pdi' => 'ES',
        'pdt' => 'EF',
        'udi' => 'LS',
        'udt' => 'LF',
    ],
];