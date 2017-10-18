<div>
    @if ($nome)
        <p>Oi, {{ $nome }}!</p>
    @else
        <p>Olá!</p>
    @endif
    <p>
        Ficamos muito tristes por saber que nossa aplicação não está 
        agradando o suficiente.
    </p>
    <p>
        Não se preocupe, faremos o possível para atender as suas expectativas
        e resolver os pontos que você levantou.
    </p>
    <p>
        Abraços da equipe Projeto Besouro.
    </p>
    <pre>{{ $mensagem }}</pre>
</div>