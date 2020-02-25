<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    // indico quali sono i campi 'fillabili', in automatico, tramite il metodo fill()
    // cioè quando utilizzo il metodo fill(), Laravel automaticamente mi copia nel mio
    // oggetto (che è poi un record) che va scritto nel DB, i campi(colonne) che
    // nella tabella del DB hanno quel nome
    protected $fillable=['title', 'author', 'content', 'category_id'];


    // definisco un metodo 'category()' che ha il nome della tabella verso la quale esiste la relazione, vado a
    // dichiarare il tipo della relazione che questa entità (ovvero il model Post) ha con un'altra entità (ovvero model Category)
    // il tipo di relazione è: 1 to Many (1 a molti)
    //
    // Questo è il lato '1' (belongsTo) della relazione '1 a molti'.
    // Nel mio DB la relazione 1 a molti sarà tra le tabelle 'categories' e 'posts':
    // per un record della tabella 'categories' possono essere associati molti records della tabella 'posts'
    public function category() {
        return $this->belongsTo('App\Category');
    }

    // dichiaro una relazione 'a molti' verso il model Tag
    // c'è una relazione molti a molti tra i model Post e Tag
    // non c'è una tabella che 'comanda' e una che è 'dipendente' come nelle relazioni '1 a molti',
    // in entrambi i Model uso il metodo "belongsToMany"

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
