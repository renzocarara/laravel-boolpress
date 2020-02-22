<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 'use' del nuovo modello creato per memorizzare i dati del messaggio inviato dall'utente
use App\PotentialCustomer;
use Illuminate\Support\Facades\Mail;
// 'use' delle classi che istanziano un oggetto che è in pratica una mail da inviare
use App\Mail\UserConfirmation;
use App\Mail\NewPotentialCustomer;

class HomeController extends Controller
{
    public function index() {

        // ritorna la view 'home', pagina iniziale pubblica
        return view('public.home');
    }

    public function contacts() {
        // ritorna la view che presenta un form per permettere all'utente di scrivere un messaggio
        // nome della view: 'contacts', sotto la cartella 'public' (che sta sotto la cartella views)
        return view('public.contacts');
    }

    public function contactsStore(Request $request) {
        // questa funzione riceve i dati del form compilato dall'utente (view 'contacts'), li memorizza nel DB
        // e poi fa una REDIRECT verso la rotta ('public.contacts.thanks')
        // per informare l'utente che la procedura è andata a buon fine

        // creo un nuovo oggetto di classe PotentialCustomer, dove memorizzerò i dati dell'utente che mi ha inviato un messaggio
        $new_message = new PotentialCustomer();
        // estraggo i dati ricevuti in post attraverso il form
        $new_message->fill($request->all());
        // salvo i dati nel DB
        $new_message->save();

        // dopo che l'utente ha inviato un messaggio per il sito Boolpress,
        // invio una email all'amministratore del sito per avvisarlo che qualcuno ha lasciato un messaggio
        // admin@boolpress.com è l'indirizzo dell'amministratore, $new_message è il messaggio lasciato dall'utente,
        // creo una nuova istanza di classe NewPotentialCustomer (che è una classe 'mailable') e ci metto dentro
        // il messaggio lasciato dall'utente. Verrà chiamata in automatico la funzione 'build' della classe
        // NewPotentialCustomer che costruisce una view che è poi il corpo (testo) della e-mail
        Mail::to('administrator@boolpress.com')->send(new NewPotentialCustomer($new_message));

        // invio email di conferma all'utente che ha lasciato il messaggio sul sito
        // che include con una copia del messaggio lasciato dall'utente stesso.
        // L'email del destinatario è l'indirizzo e-mail che l'utente ha inserito nel form ($new_message->email).
        // Per la mail che invio utilizzo una istanza di un nuovo oggetto 'mailable' UserConfirmation
        // che creo per questo tipo di risposte. Come prima quando invoco la send(), viene chiamata
        // in automatico la funzione build() della classe UserConfirmation che costruisce la view (corpo)
        // dalla mail da spedire
        Mail::to($new_message->email)->send(new UserConfirmation($new_message));

        return redirect()->route('public.contacts.thanks');
    }

    public function thanks() {
        // ritorna una view ('public.thanks') per informare l'utente che la procedura è andata a buon fine
        // nome della view: 'thanks', sotto la cartella 'public' (che sta sotto la cartella views)
        return view('public.thanks');
    }
}
