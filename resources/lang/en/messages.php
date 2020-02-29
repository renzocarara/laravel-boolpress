<?php

// COME FUNZIONA:
// nei file blade.php andrò a sostituire il testo da tradurre con una chiamata alla funzione di traduzione __(),
// con questa sintassi: {{ __('nome_file.nome_della_chiave') }}
// ad esempio: {{ __('messages.account_details_title') }}
// dove 'messages' è il nome del file e 'account_details_title' e la chiave con cui accedo all'elemento dell'array
// che mi fornisce il testo tradotto nella lingua specifica (vedi l'array qui sotto)

return [
    // view admin\account
    'account_title' => 'Your Profile',
    'account_subtitle' => 'Hello :name!',
    'account_details_title' => 'Here your details',

    // generici
    'firstname' => "Firstname",
    'lastname' => "Lastname",

    // view home (pubblica)
    'home_title' => 'Welcome in BoolPress Blog!',

    // view contacts
    'contacts_title' => 'Fill in the form and send us a message!',
    'name' => 'Name',
    'email' => 'Email',
    'subject' => 'Subject',
    'message' => 'Message',
    'write_here' => 'Start to write',
    'send_msg' => 'Send message'

];
