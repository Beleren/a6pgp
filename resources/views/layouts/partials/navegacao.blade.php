<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }} ">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @if (! Auth::guest())
                    <li>
                        <a href="{{ route('projetos.index') }}" class="active"
                       data-toggle="tooltip" data-placement="bottom" title="@lang('paginas.navegacao.descricoes.projetos')">@lang('paginas.navegacao.projetos')</a>
                    </li>

                    @if(isset($projeto))
                    <li>
                        <a href="{{ route('atividades.index', ['projeto' => $projeto->id]) }}"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('paginas.navegacao.descricoes.atividades')"
                        >@lang('paginas.navegacao.atividades')</a>
                    </li>
                    <li>
                        <a href="{{ route('recursos.index', ['projeto' => $projeto->id]) }}"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('paginas.navegacao.descricoes.recursos')">@lang('paginas.navegacao.recursos')</a>
                    </li>
                    <li>
                        <a href="{{ route('cenarios.index', ['projeto ' => $projeto->id]) }}"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('paginas.navegacao.descricoes.cenarios')">@lang('paginas.navegacao.cenarios')</a>
                    </li>
                    <li>
                        <a href="{{ route('sequencias.index', ['projeto' => $projeto->id,
                        'cenario' => $projeto->cenarios->first() ]) }}"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('paginas.navegacao.descricoes.gerenciar-dependencias')"
                        >@lang('paginas.navegacao.gerenciar-dependencias')</a>
                    </li>
                    @endif
                @endif
                <li>
                    <a href="{{ route('home.sobre') }}">@lang('paginas.navegacao.sobre')</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">@lang('paginas.login')</a></li>
                    <li><a href="{{ route('register') }}">@lang('paginas.register')</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    @lang('paginas.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
                <li id="idiomas">
                    <img id="idioma-portugues" src="{{ asset('img/brazil-flag.png') }}" class="img-responsive pull-left" alt="Bandeira do Brasil">
                    <img id="idioma-ingles" src="{{ asset('img/united-states-flag.png') }}" class="img-responsive pull-right" alt="Bandeira dos Estados Unidos">
                </li>
            </ul>
        </div>
    </div>
</nav>