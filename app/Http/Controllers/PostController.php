<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// aggiungo questa use  per poter usare i metodi dulla classe Category (es. all(), where(), etc)
use App\Category;

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

        // cerco nella colonna 'slug' della mia tabella 'posts', il post(record) con slug uguale al parametro ricevuto
        $post = Post::where('slug', $slug)->first();

        // verifico se la select fatta sul DB mi ha ritornato un post tramite lo slug
        // ad esempio l'utente potrebbe modificare la stringa nella barra indirizzi, alterando il nome
        // dello slug e scrivendo un qualcosa che non ha corrispondenza con alcun post del DB
        if (!empty($post)) {
            // ritorna una view con i dati del singolo post ricercato
            return view('public.posts.show', ['post' => $post]);
        } else {
            // ritorno la pagina di errore "Page not found" poichè lo slug ricevuto in ingresso
            // non corrisponde a nessuna post presente nel mio DB (tabella 'posts')
            return abort(404);
        }
    }

    public function postCategory($slug) {

        // NOTA: nella tabella 'categories' ho 2 colonne:
        // 'description' che è il nome per esteso della categoria
        // 'slug' che è appunto lo slug ricavato dal nome per esteso della categoria
        // questa funzione riceve in ingresso lo slug ($slug) della categoria
        // e deve ricavare l'elenco di tutti i posts che hanno la stessa categoria
        // identificata dallo slug ricevuto come parametro in ingresso.
        // Poi la funzione richiama una view e le passa l'elenco di tutti i posts trovati
        // che hanno appunto come categoria quella identificata dallo slug ricevuto in ingresso

        // cerco nella colonna 'slug' della mia tabella 'categories', la categoria (record) con slug uguale al parametro ricevuto
        $category = Category::where('slug', $slug)->first();

        // verifico se la select fatta sul DB mi ha ritornato qualcosa per la categoria ricercata tramite slug
        // ad esempio l'utente potrebbe modificare la stringa nella barra indirizzi, alterando il nome
        // dello slug e scrivendo un qualcosa che non esiste e non corrisponde a nessuna categoria del DB
        if (!empty($category)) {
            // qui sfrutto la relazione fra categorie e posts, cioè la rlazione fra le entità/modelli
            // Category e Post. Nellla classe Category è definito un metodo posts()
            // (cioè col nome dell'entità verso la quale è definita la relazione)
            // posts() ritorna $this->hasMany('App\Post');
            // chiamo la proprietà post (in questa maniera'$category->posts')
            // che restituisce i post che sono legati da relazione in base alla categoria
            $posts_by_category = $category->posts;

            // chiamo una view per visualizzare tutti i post della categoria ricercata,
            // gli passo la categoria e l'elenco dei posts
            return view('public.posts.posts-by-category', [
                'category' => $category,
                'posts' => $posts_by_category
            ]);
        } else {
            // ritorno la pagina di errore "Page not found" poichè lo slug ricevuto in ingresso
            // non corrisponde a nessuna categoria presente nel mio DB (tabella 'categories')
            return abort(404);
        }
    }
}
