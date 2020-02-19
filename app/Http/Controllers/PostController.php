<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        // leggo tutti i post dal DB
        $posts = Post::all();
        // ritorna una view con l'elenco di tutti i post
        return view('public.posts.index', ['posts' => $posts]);
    }

    public function show($slug) {

        // cerco nella colonna 'slug' della mia tabella del DB, il post con slug uguale al parametro ricevuto
        $post = Post::where('slug', $slug)->first();
        // ritorna una view con i dati del singolo post ricercato
        return view('public.posts.show', ['post' => $post]);
    }
}
