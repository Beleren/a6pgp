<div class="panel-group col-sm-3 col-md-3" id="accordion" role="tablist" aria-multiselectable="true">
    <!-- Atividades -->
    <div class="panel panel-primary">
        <div class="panel-heading" role="tab" id="headingAtividades">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseAtividades" aria-expanded="true"
                    aria-controls="collapseAtividades">
                    Atividades
                </a>
            </h4>
        </div>
        <div id="collapseAtividades" class="panel-collapse collapse in"
            role="tabpanel" aria-labelledby="headingAtividades">
            <div class="panel-body">
                <ul id="lista-atividades" class="atividades list-group">
                    @forelse($atividades as $atividade)
                        <li class="list-group-item atividades"
                            data-atividade-id="{{ $atividade->id }}">
                            {{ $atividade->nome }}
                        </li>
                    @empty
                        <span>Não há atividades cadastradas.</span>
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
                    Recursos
                </a>
            </h4>
        </div>
        <div id="collapseRecursos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRecursos">
            <div class="panel-body">
                <ul id="lista-recursos" class="recursos list-group">
                    @forelse($recursos as $recurso)
                        <li class="list-group-item recursos"
                            data-recurso-id="{{ $recurso->id }}">
                            {{ $recurso->nome }}
                        </li>
                    @empty
                        <span>Não há recursos cadastrados.</span>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>