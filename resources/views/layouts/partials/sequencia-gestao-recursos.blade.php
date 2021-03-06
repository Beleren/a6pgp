<div class="panel-group col-sm-3 col-md-3" id="accordion" role="tablist" aria-multiselectable="true">
    <!-- Atividades -->
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingAtividades">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseAtividades" aria-expanded="true"
                    aria-controls="collapseAtividades">
                    @lang('paginas.cenarios.atividades')
                    <a class="btn btn-primary adicionar"
                       href="{{ route('atividades.create', [
                    'projeto' => $projeto->id]) }}"
                    >
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </a>
            </h4>
        </div>
        <div id="collapseAtividades" class="panel-collapse collapse in"
            role="tabpanel" aria-labelledby="headingAtividades">
            <div class="panel-body">
                <input type="text" id="filtroAtividade" onkeyup="filtrarPainel(this)" class="form-control" placeholder="">

                <ul id="lista-atividades" class="atividades list-group">
                    @forelse($atividades as $atividade)
                        <li class="list-group-item atividades"
                            data-atividade-id="{{ $atividade->id }}">
                            <span>{{ $atividade->nome }}</span>
                        </li>
                    @empty
                        <span>@lang('paginas.cenarios.sem-atividades')</span>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Recursos -->
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingRecursos">
            <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseRecursos" aria-expanded="false" aria-controls="collapseRecursos">
                    @lang('paginas.cenarios.recursos')
                    <a class="btn btn-primary adicionar"
                       href="{{ route('recursos.create', [
                    'projeto' => $projeto->id]) }}"
                    >
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </a>
            </h4>
        </div>
        <div id="collapseRecursos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRecursos">
            <div class="panel-body">
                <input type="text" id="filtroRecurso" onkeyup="filtrarPainel(this)" class="form-control" placeholder="">
                <ul id="lista-recursos" class="recursos list-group">
                    @forelse($recursos as $recurso)
                        <li class="list-group-item recursos"
                            data-recurso-id="{{ $recurso->id }}">
                            <span>{{ $recurso->nome }}</span>
                        </li>
                    @empty
                        <span>@lang('paginas.cenarios.sem-recursos')</span>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(function(){

                var app_lang = $('html').attr('lang');
                switch (app_lang) {
                    case 'en':
                        $('#filtroRecurso').attr('placeholder', 'Search ...');
                        $('#filtroAtividade').attr('placeholder', 'Search ...');
                        break;

                    case 'pt':
                        $('#filtroRecurso').attr('placeholder', 'Procurar ...');
                        $('#filtroAtividade').attr('placeholder', 'Procurar ...');
                        break;
                    default:
                        $('#filtroRecurso').attr('placeholder', 'Procurar ...');
                        $('#filtroAtividade').attr('placeholder', 'Procurar ...');
                };

        });

            //colocar parametro para saber qual input esta chamando
            function filtrarPainel(elem) {
                // Declare variables
                var input, filter, ul, li, a, i;
                input = document.getElementById(elem.id);
                filter = input.value.toUpperCase();
                if(elem.id==='filtroAtividade')
                    ul = document.getElementById("lista-atividades");
                else ul = document.getElementById("lista-recursos");
                li = ul.getElementsByTagName('li');

                // Loop through all list items, and hide those who don't match the search query
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("span")[0];
                    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
        //})

    </script>
@endsection