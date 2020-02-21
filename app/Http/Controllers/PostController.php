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

    public function index($page_num) {

        // numero massimo di post da visualizzare per pagina (costante)
        $max_posts_per_page=3;

        // leggo tutti i post dal DB
        $posts = Post::all();

        // estraggo il numero totale di posts
        $total_posts_in_DB=$posts->count();

        // in base al numero di pagina richiesta, calcolo la posizione da cui estrarre i post
        if($page_num == 1){
            $from = 0;
        } else{
            $from = ($page_num - 1) * $max_posts_per_page;
        }

        // leggo dalla posizione '$from' per '$max_post_per_page' elementi e creo una 'sub-collection'
        $posts_in_the_page = $posts->slice($from, $max_posts_per_page);

        // ritorno una view con con una collection di post da visualizzare su una singola pagina
        // gli passo anche altri 3 parametri:
        // - il numero di pagina per la quale ho estratto i post
        // - il numero totale di posts nel DB
        // - il numero massimo di post da visualizzare per una singola pagina (costante)
        return view('public.posts.index', ['posts_in_the_page' => $posts_in_the_page,
                                           'page_num' => $page_num,
                                           'total_posts_in_DB' => $total_posts_in_DB,
                                           'max_posts_per_page' => $max_posts_per_page]);
    }

    public function show($slug) {

        // cerco nella colonna 'slug' della mia tabella del DB, il post con slug uguale al parametro ricevuto
        $post = Post::where('slug', $slug)->first();
        // ritorna una view con i dati del singolo post ricercato
        return view('public.posts.show', ['post' => $post]);
    }

}
