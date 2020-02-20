<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    // public function index() {
    //     // leggo tutti i post dal DB
    //     $posts = Post::all();
    //     // ritorna una view con l'elenco di tutti i post
    //     return view('public.posts.index', ['posts' => $posts]);
    // }
    public function index($from, $direction) {
        // numero di post per pagina
        $post_per_page=3;

        // leggo tutti i post dal DB
        $posts = Post::all();

        $num_of_posts=$posts->count();
        // echo $num_of_posts;

        // calcolo il parameto per la slice()
        // ($direction=='next') ? ($to=$from + $post_per_page) : ($to=$from - $post_per_page);

        // leggo da posizione start_from per how_many elementi e creo una 'sub-collection'
        $page = $posts->slice($from, $post_per_page);
        $page->all();

        // ritorna una view con l'elenco dei post per una pagina
        return view('public.posts.index', ['posts' => $page,
                                            'from' => $from]);
    }

    public function show($slug) {

        // cerco nella colonna 'slug' della mia tabella del DB, il post con slug uguale al parametro ricevuto
        $post = Post::where('slug', $slug)->first();
        // ritorna una view con i dati del singolo post ricercato
        return view('public.posts.show', ['post' => $post]);
    }

}
