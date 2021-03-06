
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data: {

    },
    methods: {

    }
});

window.Viz = require('viz.js');

$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#idioma-portugues').on('click', function (event) {
        event.stopPropagation();

        $.get('/idiomas/pt', function (data) {
            console.log('Idioma português selecionado.');
        });

        location.reload();
    });

    $('#idioma-ingles').on('click', function (event) {
        event.stopPropagation();

        $.get('/idiomas/en', function(data) {
            console.log('Idioma inglês selecionado.')
        });

        location.reload();
    });
});