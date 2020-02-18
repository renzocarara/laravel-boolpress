<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        // richiama la view principale del sito lato back-office (privato - autenticazione richiesta)
        return view('admin.home'); // prefisso_nome_view: 'admin.' + nome_view: 'home'
    }
}
