<div>
    @if ($nome)
        <p>Oi, {{ $nome }}!</p>
    @else
        <p>Olá!</p>
    @endif
    <p>
        Agradecemos pela sua disposição em nos ajudar a melhorar ainda mais a sua experiência
        como usuário relatando este erro.
    </p>
    <p>
        Não se preocupe, faremos o possível para resolver os erros informados.
    </p>
    <p>
        Abraços da equipe Projeto Besouro.
    </p>
    <pre>{{ $mensagem }}</pre>
</div>