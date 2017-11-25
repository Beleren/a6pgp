$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#idioma-portugues').on('click', function (event) {
        event.stopPropagation();

        $.get('/idiomas/pt', function (data) {
            console.log('Idioma português selecionado.');
        });

        window.location.reload(true);
    });

    $('#idioma-ingles').on('click', function (event) {
        event.stopPropagation();

        $.get('/idiomas/en', function(data) {
            console.log('Idioma inglês selecionado.')
        });

        window.location.reload(true);
    });
});