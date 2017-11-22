<?php

namespace Tests\Browser;

use App\Projeto;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use function Psy\debug;
use SebastianBergmann\Environment\Console;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GerenciamentoDeProjetosViaBrowserTest extends DuskTestCase
{
    use DatabaseTransactions;

    private $user;

    /**
     * Configuração global
     */
    public function inicializarConfiguracoes()
    {
        $this->user = User::first();

        if (! $this->user)
        {
            $this->user = factory(User::class)->create([
                'name' => 'Marivaldo Sena',
                'email' => 'msena.ifsp@gmail.com',
                'password' => bcrypt('Senha@123'),
            ]);
        }
    }

    public function finalizarConfiguracoes()
    {
        $this->user = null;
    }

    /**
     * Criação de um projeto por usuário autenticado.
     *
     * @return void
     */
    public function testCriarProjetoComoUsuarioAutenticado()
    {
        $this->inicializarConfiguracoes();

        $user = $this->user;

        $numero = mt_rand(1, 100);
        $projeto = 'Projeto Teste Dusk ' . $numero;

        $this->browse(function (Browser $browser) use ($user, $projeto, $numero) {
            $browser
                /*
                 * Usuário autenticado cria projeto.
                 */

                ->loginAs($user)
                ->visit('/projetos')
                ->assertPathIs('/projetos')
                ->clickLink('Criar Projeto')
                ->pause(300)
                ->assertPathIs('/projetos/create')
                ->type('nome', $projeto)
                ->press('Criar')
                ->pause(300)
                ->assertSee($projeto)
            ;
        });
    }

    /**
     * Visualização de um projeto.
     * @return void
     */
    public function testVisualizarProjetoComoUsuarioAutenticado()
    {
        $this->inicializarConfiguracoes();
        $user = $this->user;
        $projeto = Projeto::last();

        $this->browse(function (Browser $browser) use ($user, $projeto) {
            $browser
//                ->visit('/projetos')
//                ->pause(300)
//                ->assertPathIs('/projetos/' . $projeto->id)
//                ->assertSee($projeto->nome)
            ;
        });
    }

    /**
     * Edição de projeto.
     */
    public function testEditarProjetoComoUsuarioAutenticado()
    {
        $this->inicializarConfiguracoes();
        $user = $this->user;
        $projeto = Projeto::last();

        $this->browse(function (Browser $browser) use ($user, $projeto) {
            $browser
//                ->visit('/projetos')
//                ->clickLink('Editar')
//                ->pause(300)
//                ->assertPathIs('/projetos/' . $projeto->id . '/edit')
//                ->type('nome', 'Projeto Test Dusk Editado ' . $projeto->id)
//                ->type('descricao', mt_rand(1, 100))
//                ->press('Alterar')
//                ->assertPathIs('/projetos/' . $projeto->id)
//                ->assertSee('Projeto Test Dusk Editado ' . $projeto->id)
            ;
        });
    }

    /**
     * Exclusão de projeto.
     */

    public function testExcluirProjetoComoUsuarioAutenticado()
    {
        $this->inicializarConfiguracoes();
        $user = $this->user;
        $projeto = Projeto::last();

        // TODO: Implementar teste de exclusão.
        $this->browse(function (Browser $browser) use ($user, $projeto) {
//            $browser
//                ->visit('/projetos');
        });
    }
}
