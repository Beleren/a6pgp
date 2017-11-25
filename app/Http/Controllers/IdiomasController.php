<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdiomasController extends Controller
{
    public function alterarIdioma($idioma) {
        switch($idioma) {
            case 'en':
                app()->setLocale('en');
                session()->put('idioma', 'en');
                break;
            case 'pt':
                app()->setLocale('pt');
                session()->put('idioma', 'pt');
                break;
            default:
                app()->setLocale('pt');
                session()->put('idioma', 'pt');
        }

        session()->save();
        return app()->getLocale();
    }
}
