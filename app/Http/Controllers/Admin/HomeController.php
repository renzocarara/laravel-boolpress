<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App;


class HomeController extends Controller
{
    public function index() {
        // richiama la view principale del sito lato back-office (privato - autenticazione richiesta)
        return view('admin.home'); // prefisso_nome_view: 'admin.' + nome_view: 'home'
    }


    public function account() {
        App::setLocale('it');
        // recupero l'utente corrente
        $user = Auth::user();
        // recupero i dettagli dell'utente corrente tramite la relazione uno a uno
        $user_details = $user->userDetail;
        // ritorno la view admin.account e le passo i dettagli utente
        return view('admin.account', ['user_details' => $user_details]);
    }

    // generazione di un API token per l'utente, per permettergli l'uso delle API
    // genera il token e lo scrive nel DB
    public function generaToken() {
        // genero un nuovo token per l'utente
        $token = Str::random(80);
        // recupero l'utente corrente
        $user = Auth::user();
        // assegno il token appena generato all'utente
        $user->api_token = $token;
        // salvo nel db, tabella 'users', colonna 'api_token'
        $user->save();
        // ritorno alla home
        return redirect()->route('admin.home');
    }
}
