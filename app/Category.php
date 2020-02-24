<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // definisco un metodo 'posts()' che ha il nome della tabella verso la quale esiste la relazione, vado a
    // dichiarare il tipo della relazione che questa entità (ovvero il model Category) ha con un'altra entità (ovvero model Post)
    // il tipo di relazione è: 1 to Many (1 a molti)
    //
    // Questo è il lato 'Molti' della relazione '1 a molti', quindi sarà su questo lato che avrò
    // la FOREIGN KEY
    public function posts() {
        return $this->hasMany('App\Post');
    }
}
