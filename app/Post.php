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
    protected $fillable=['title','author','content','cover_image'];
}
