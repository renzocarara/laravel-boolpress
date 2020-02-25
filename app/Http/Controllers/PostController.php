<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// aggiungo queste use per poter usare le classi
use App\Category;
use App\Tag;

class PostController extends Controller
{
    public function index() {

        // leggo tutti i post dal DB
        $posts = Post::all();
        $total_number_of_posts = $posts->count();

        // imposto la paginazione automatica di Laravel - 5 elementi per pagina
        $posts = Post::paginate(5);

        // ritorno una view con con una collection di post da visualizzare
        // e il numero totale di post nel DB
        return view('public.posts.index', ['posts' => $posts, 'total_posts' => $total_number_of_posts]);
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

        // NOTA: nella tabella 'categories' ho, tra le altre, 2 colonne:
        // 'name' che è il nome per esteso della categoria
        // 'slug' che è lo slug ricavato dal nome per esteso della categoria
        // questa funzione riceve in ingresso lo slug ($slug) della categoria
        // e deve ricavare l'elenco di tutti i posts che hanno quella categoria associata
        // identificati dallo slug ricevuto come parametro in ingresso.
        // Poi la funzione richiama una view e le passa l'elenco di tutti i posts trovati
        // e l'oggetto categoria, quella identificata dallo slug ricevuto in ingresso

        // cerco nella colonna 'slug' della mia tabella 'categories', la categoria (record) con slug uguale al parametro ricevuto
        $category = Category::where('slug', $slug)->first();

        // verifico se la select fatta sul DB mi ha ritornato qualcosa per la categoria ricercata tramite slug
        // ad esempio l'utente potrebbe modificare la stringa nella barra indirizzi, alterando il nome
        // dello slug e scrivendo un qualcosa che non esiste e non corrisponde a nessuna categoria del DB
        if (!empty($category)) {
            // qui sfrutto la relazione fra categorie e posts, cioè la relazione fra le entità/modelli
            // Category e Post. Nella classe Category è definito un metodo posts()
            // (cioè col nome dell'entità verso la quale è definita la relazione)
            // posts() ritorna $this->hasMany('App\Post');
            // chiamo la proprietà posts (in questa maniera'$category->posts')
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

    public function postTag($slug) {

        // NOTA: nella tabella 'tags' ho, tra le altre, 2 colonne:
        // 'name' che è il nome per esteso del tag
        // 'slug' che è lo slug ricavato dal nome per esteso del tag
        // questa funzione riceve in ingresso lo slug ($slug) del tag
        // e deve ricavare l'elenco di tutti i posts che hanno quel tag associato
        // identificati dallo slug ricevuto come parametro in ingresso.
        // Poi la funzione richiama una view e le passa l'elenco di tutti i posts trovati
        // e l'oggetto categoria, quella identificata dallo slug ricevuto in ingresso

        // cerco nella colonna 'slug' della mia tabella 'tags', il tag (record) con slug uguale al parametro ricevuto
        $tag = Tag::where('slug', $slug)->first();

        // verifico se la select fatta sul DB mi ha ritornato qualcosa per il tag ricercato tramite slug
        // ad esempio l'utente potrebbe modificare la stringa nella barra indirizzi, alterando il nome
        // dello slug e scrivendo un qualcosa che non esiste e non corrisponde a nessun tag del DB
        if (!empty($tag)) {
            // qui sfrutto la relazione fra tags e posts, cioè la relazione fra le entità/modelli
            // Tag e Post. Nella classe Tag è definito un metodo posts()
            // (cioè col nome dell'entità verso la quale è definita la relazione)
            // posts() ritorna $this->hasMany('App\Post');
            // chiamo la proprietà posts (in questa maniera'$tag->posts')
            // che restituisce i post che sono legati da relazione in base al tag
            $posts_by_tag = $tag->posts;

            // chiamo una view per visualizzare tutti i post del tag ricercato,
            // gli passo il tag e l'elenco dei posts
            return view('public.posts.posts-by-tag', [
                'tag' => $tag,
                'posts' => $posts_by_tag
            ]);
        } else {
            // ritorno la pagina di errore "Page not found" poichè lo slug ricevuto in ingresso
            // non ha corrispondenza nel mio DB (tabella 'tags')
            return abort(404);
        }
    }
}
