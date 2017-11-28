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
    'alterar' => 'Atualizar',
    'confirmar-exclusao' => 'Confirmar Exclusão',
    'sair' => 'Sair',
    'descricao' => 'Descrição',
    'nome' => 'Nome',
    'excluir' => 'Excluir',
    'sair' => 'Sair',
    'salvar' => 'Salvar',


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
                'proprio' => 'Próprio',
                'compartilhado' => 'Compartilhado',
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

        'atividade-criada-sucesso' => 'Atividade criada com sucesso!',
        'atividade-alterada-sucesso' => 'Atividade alterada com sucesso!',
        'atividade-excluida-sucesso' => 'Atividade excluída com sucesso e todas as sequências relacionadas!',
    ],

    'recursos' =>
    [
        'index' =>
        [
            'criar-recurso' => 'Criar Recurso',
            'tipo-recurso' => 'Tipo de Recurso',
            'custo-unitario' => 'Custo Unitário',
            'custo-unico' => 'Custo Único',
            'sem-recursos' => 'Não há recursos cadastrados.',

            'tipos-recursos' =>
            [
                'humano' => 'Humano',
                'fisico' => 'Físico',
                'financeiro' => 'Financeiro',
                'tecnologico' => 'Tecnológico',
            ],
        ],

        'deseja-excluir' => 'Deseja excluir permanentemente o recurso abaixo?',
        'recurso-criado' => 'Recurso criado com sucesso!',
        'recurso-atualizado' => 'Recurso alterado com sucesso!',
        'recurso-excluido' => 'Recurso excluído com sucesso e todas as sequências relacionadas!',
    ],

    'cenarios' =>
    [
        'criar-cenario' => 'Criar Cenário',
        'data-criacao' => 'Data de Criação',
        'visualizar-sequencias' => 'Visualizar Sequências',
        'deseja-excluir' => 'Deseja excluir permanentemente o cenário abaixo?',
        'cenario-criado-sucesso' => 'Cenário criado com sucesso!',
        'cenario-atualizado' => 'Cenário atualizado com sucesso!',
        'cenario-excluido' => 'Cenário excluído com sucesso com todas as sequências relacionadas!',
        'cenario' => 'Cenário',
        'atividade' => 'Atividade',
        'atividades-predecessoras' => 'Atividades Predecessoras',
        'recursos' => 'Recursos',
        'atividades' => 'Atividades',
        'recursos' => 'Recursos',
        'sem-atividades' => 'Não há atividades cadastradas.',
        'sem-recursos' => 'Não há recursos cadastrados.',
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
        'recurso' => 'Recurso',
        'cenario' => 'Cenário'
    ],

    'carousel' =>
    [
        'gerenciamento-projeto' => 'Gerenciamento de projetos mais inteligente com o planejamento dinâmico.',
        'foco-didatico' => 'Gerenciamento de projetos com um foco mais didático.',
        'open-source' => 'Sobre os ombros de gigantes da comunidade open source.',
    ],

    'home' =>
    [
        'como-nasceu' => 'O projeto Besouro nasceu como um requerimento da matéria de Práticas de Gerenciamento de Projetos (A6PGP)
        para conclusão do curso de Tecnologia em Análise e Desenvolvimento de Sistemas (TADS) do
        Instituto Federal de São Paulo (IFSP).',
        'objetivo-projeto' => 'O objetivo deste projeto é disponibilizar uma aplicação que permita o planejamento de projetos utilizando
        a rede Program Evaluation and Review Technique (PERT) e o Critical Path Method (CPM). As funcionalidades
        disponíveis são:',
        'programacao-atividades' => 'Programação de atividades',
        'construcao-rede' => 'Construção da rede',
        'caminho-critico' => 'Cálculo de Caminho Crítico',
        'importacao-exportacao-excel' => 'Importação e Exportação de Projeto em planilhas de Excel',
        'disponivel-via-web' => 'Sistema disponível para diversas plataformas via web',
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
                        'integer' => 'Duração deve ser um tipo numérico.',
                        'min' => 'Duração deve ser maior quer zero.',
                    ],

                    'requerRecursos.in' => 'Requer Recurso deve ser um valor verdadeiro ou falso.',
                    'inicioOtimista.date' => 'Início Otimista deve ter um formato de data.',
                    'inicioPessimista.after_or_equal' => 'Início Pessimista deve ser posterior ou igual a data de hoje.',
                    'fimOtimista.date' => 'Fim Otimista deve ter um formato de data.',
                    'fimPessimista.after_or_equal' => 'Fim Pessimista deve ser posterior ou igual a data de hoje.',
                ],

                'recursos' =>
                [
                    'qtd' =>
                    [
                        'numeric' => 'Quantidade deve ser um número inteiro.',
                        'min' => 'Quantidade deve ser maior que zero.',
                    ],
                    'dataDispRecurso.date' => 'Data de Disponibilização do Recurso está em formato inválido.',
                    'data.after' => 'Data de Disponibilização do Recurso deve posterior ou igual a data de hoje.',

                    'tempoAlocado' =>
                    [
                        'timezone' => 'Tempo Alocado deve ter formato de horário.',
                        'min' => 'Tempo Alocado não pode ser negatívo.',
                    ],
                ],
            ],
        ],
        'salvar-cenario' => 'Salvar Cenário',
        'salvar-novo-cenario' => 'Salvar em Novo Cenário',
        'diagrama' => 'Diagrama',
        'atividade' => 'Atividade',
        'duracao' => 'Duração',
        'requer-recursos' => 'Requer Recursos?',
        'inicio-otimista' => 'Início Otimista',
        'inicio-pessimista' => 'Início Pessimista',
        'fim-otimista' => 'Fim Otimista',
        'fim-pessimista' => 'Fim Pessimista',
        'quantidade-recurso' => 'Quantidade de Recurso',
        'data-disp-recurso' => 'Data de Disponibilização do Recurso',
        'tempo-alocado' => 'Tempo Alocado',
    ],

    'registrar' =>
    [
        'name' =>
        [
            'required' => 'O campo nome é obrigatório.',
            'string' => 'O campo nome deve ser um tipo textual.',
            'max' => 'O campo nome não pode exceder 255 caracteres',
            'min' => 'O campo nome deve possuir pelos menos 3 caracteres',
        ],

        'email' =>
        [
            'required' => 'O campo e-mail é obrigatório.',
            'string' => 'O campo e-mail deve ser do tipo textual.',
            'formato' => 'O e-mail está em formato inválido.',
            'unique' => 'Este e-mail já está sendo utilizado.',
        ],

        'password' =>
        [
            'require' => 'O campo senha é obrigatório.',
            'string' => 'O campo senha deve ser do tipo textual.',
            'min' => 'O campo senha deve possuir pelo menos 6 caracteres.',
            'confirmed' => 'Os campos referentes à senha não conferem.',
            'regex' => 'Digite uma senha com pelos menos duas letras minúsculas, uma maiúscula e um caractere especial.',
        ],
    ],
];