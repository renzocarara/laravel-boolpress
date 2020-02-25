<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['name', 'slug'];

    public function posts() {
        // dichiaro una relazione 'a molti' verso il model Post
        // c'è una relazione molti a molti tra i model Post e Tag
        // non c'è una tabella che 'comanda' e una che è 'dipendente' come nelle relazioni '1 a molti',
        // in entrambi i Model uso il metodo "belongsToMany"
        return $this->belongsToMany('App\Post');
    }
}
