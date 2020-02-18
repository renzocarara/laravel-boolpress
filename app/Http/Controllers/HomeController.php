<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        // ritorna la view 'home', pagina iniziale pubblica
        return view('public.home');
    }
}
