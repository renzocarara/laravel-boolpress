<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    // definisco un attributo della mia classe UserConfirmation, che verrà inizializzato dal costruttore
    // al momento dell'istanzizione con i dati che gli vengono passati
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($new_message)
    {
        // inizializzo l'attributo 'msg' del mio oggetto di classe UserConfirmation con il dato $new_message
        // in ingresso al momento dell'istanziazione
        $this->msg = $new_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');

        // questa funzione viene chiamata in automatico quando voglio inviare una mail (invoco Mail::to())
        // restituisce una view, che è il corpo (testo) della mail che viene inviata

        // return $this->view('view.name');

        // noreply@boolpress.com è l'indirizzo del mittente, cioè sarebbe il sistema, ovvero la mia applicazione Laravel,
        // che invia in automatico una email,
        // (NOTA: anche se questo indirizzo non esistesse, fosse fittizio, non cambierebbe nulla,
        // il destinatario è l'utente che ha lasciato il messaggio sul sito
        // il destinatario '$new_message->email' è specificato nella chiamata:
        // Mail::to($new_message->email)->send(new UserConfirmation($new_message));
        // che si trova nell'HomeController nel metodo contactStore()
        return $this->from('noreply@boolpress.com')
        ->subject('Nuovo messaggio da Boolpress Blog')
        ->view('mail.ack_to_user');
    }
}
