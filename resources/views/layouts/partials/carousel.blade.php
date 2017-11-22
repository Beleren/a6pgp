<div class="row">
    <div id="projeto-besouro-carousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators" >
            <li data-target="#projeto-besouro-carousel" data-slide-to="0" class="active" ></li>
            <li data-target="#projeto-besouro-carousel" data-slide-to="1"></li>
            <li data-target="#projeto-besouro-carousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ asset('img/software-de-gerenciamento-de-projetos.jpg') }}" alt="Gerente planejando o projeto.">
                <div class="carousel-caption">
                    Gerenciamento de projetos mais inteligente com o planejamento dinâmico.
                </div>
            </div>
            <div class="item">
                <img src="{{ asset('img/foco-didatico.png') }}" alt="Foco didático para o ensino de gerenciamento de projetos.">
                <div class="carousel-caption">
                    Gerenciamento de projetos com um foco mais didático.
                </div>
            </div>
            <div class="item">
                <img src="{{ asset('img/open-source.png') }}" alt="Ferramentas open source.">
                <div class="carousel-caption">
                    Sobre os ombros de gigantes da comunidade open source.
                </div>
            </div>
        </div>

        <!-- Controls -->
        {{--<a class="left carousel-control" href="#projeto-besouro-carousel" role="button" data-slide="prev">--}}
            {{--<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
            {{--<span class="sr-only">Previous</span>--}}
        {{--</a>--}}
        {{--<a class="right carousel-control" href="#projeto-besouro-carousel" role="button" data-slide="next">--}}
            {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
            {{--<span class="sr-only">Next</span>--}}
        {{--</a>--}}
    </div>
</div>