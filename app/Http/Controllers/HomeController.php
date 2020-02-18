<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        // ritorna la view 'homepage', pagina iniziale pubblica
        return view('homepage');
    }
}
