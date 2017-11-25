<?php

return [

    // Palavras em Nível Global da Aplicação
    'password' => 'Senha',
    'email' => 'E-mail',
    'register' => 'Cadastrar',
    'login' => 'Acessar',
    'logout' => 'Sair',
    'cenario_padrao' => 'Cenário Padrão',
    'voltar' => 'Voltar',
    'alterar' => 'Alterar',
    'confirmar-exclusao' => 'Confirmar Exclusão',
    'sair' => 'Sair',
    'descricao' => 'Descrição',
    'nome' => 'Nome',


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

    'navegacao' =>
    [
        'projetos' => 'Projetos',
        'sobre' => 'Sobre',
        'atividades' => 'Atividades',
        'recursos' => 'Recursos',
        'cenarios' => 'Cenários',
        'gerenciar-dependencias' => 'Gerenciar Dependências',

        'descricoes' =>
        [
            'projetos' => 'Gerencie seus projetos.',
            'atividades' => 'Gerencie suas atividades.',
            'recursos' => 'Gerencie seus recursos.',
            'cenarios' => 'Gerencie os cenários de um mesmo projeto.',
            'gerenciar-dependencias' => 'Gerencie as dependências das atividades de um determinado cenário.',
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
                'compartilhar-sucesso' => 'Projeto foi compartilhado com sucesso!',
                'compartilhar-erro' => 'Algo deu errado! Por favor, tente novamente.',
                'projeto-criado-sucesso' => 'Projeto criado com sucesso!',
                'projeto-alterado-sucesso' => 'Projeto alterado com sucesso!',
                'projeto-excluido-sucesso' => 'O projeto foi excluído com sucesso e todas as atividades e recursos relacionados.',
                'compartilhar-emails-ausentes' => 'Digite o(s) e-mail(s) do(s) usuário(s) com quem deseja compartilhar.',
                'compartilhar-usuario-inexistente' => 'Não foi possível compartilhar o projeto com o seguinte usuário|Não foi possível compartilhar o projeto com os seguintes usuários',
                'compartilhar-verificar-email' => 'Verifique o e-mail digitado.|Verifique os e-mails digitados.',
                'compartilhar-usuarios-com-acesso' => 'O usuário a seguir já está com este projeto sendo compartilhado|Os usuários a seguir já estão com este projeto sendo compartilhado',
            ],

            'botoes' =>
            [
                'criar' => 'Criar Projeto',
                'compartilhar' => 'Compartilhar',
                'editar' => 'Editar',
                'excluir' => 'Excluir',
            ],
        ],

        // views/projetos/edit.blade.php
        'edit' =>
        [
            'projeto' => 'Projeto:',
            'descricao' => 'Descrição:',
        ],

        // views/projetos/confirm-delete.blade.php
        'confirm-delete' =>
        [
            'deseja-excluir' => 'Você deseja excluir permanentemente o projeto abaixo?',
        ],

        // views/layouts/partials/compartilhar-projeto.blade.php
        'modal-compartilhar' =>
        [
            'compartilhar-projeto' => 'Compartilhar Projeto',
            'digite-emails' => 'Digite o(s) e-mail(s) do(s) usuário(s) que você deseja compartilhar este projeto separados por vírgula (&semi;).',
            'projeto' => 'Projeto:',
            'placeholder-emails' => 'Digite os e-mails separados por vírgula (&semi;) aqui.',
        ],

        'show' =>
        [
            'atividades' => 'Atividades',
            'cenarios' => 'Cenários',
            'recursos' => 'Recursos',

            'descricoes' =>
            [
                'atividades' => 'Clique aqui para visualizar mais atividades.',
                'recursos' => 'Clique aqui para visualizar mais recursos.',
                'cenarios' => 'Clique aqui para visualizar mais cenários.'
            ],
        ],
    ],

    'atividades' =>
    [
        'index' =>
        [
            'criar-atividade' => 'Criar Atividade',
            'sem-atividades' => 'Não há atividades cadastradas.',
        ],

        'confirm-delete' =>
        [
            'deseja-excluir' => 'Deseja excluir permanentemente a atividade abaixo?',
            'excluir' => 'Excluir Atividade',
        ],
    ],

    'tabelas' =>
    [
        'projeto' => 'Projeto',
        'autoria' => 'Autoria',
        'criado-em' => 'Criado Em',
        'acoes' => 'Ações',
        'atividades' => 'Atividades',
        'descricao' => 'Descrição',
        'editar' => 'Editar',
        'excluir' => 'Excluir',
    ],
];