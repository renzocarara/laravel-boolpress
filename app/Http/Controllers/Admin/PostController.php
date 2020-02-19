<?php

// aggiungo il namespace corretto (quindi Admin)
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

// aggiungo questa use per poter usare la funzione str()
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // questo metodo recupera tutti i posts dal DB e poi ritorna una view che
        // riceve in ingresso la collection dei posts e la visualizza in pagina

        $posts = Post::all();
        return view('admin.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // questo metodo viene chiamato dal controller quando l'utente preme sull'invio
        // del FORM sulla view 'create', non c'è una view che viene ritornata e che
        // l'utente può vedere, è solo uno script che serve per scrivere nel DB i dati inseriti dall'utente,
        // dopodichè viene fatta una REDIRECT verso la rotta 'admin.posts.index' (view principale)

        // metto i dati ricevuti tramite il parametro $request in una variabile
        $form_data_received=$request->all();

        // creo un nuovo oggetto di classe Post, da scrivere poi nel DB
        $new_post = new Post();

        // valorizzo il nuovo oggetto con i dati ricevuti (ad eccezione dello 'slug' che devo calcolarlo io)
        $new_post->fill($form_data_received);

        // calcolo uno slug univoco, verificando se già esiste quello che volgio scrivere
        // ricavo lo slug teorico che dovrei scrivere, in base al titolo del post
        $slug_from_title = Str::slug($form_data_received['title']);
        // mi salvo lo slug 'potenziale' in una variabile
        $slug_to_be_written = $slug_from_title;
        // ora verifico che nel db non esista uno slug uguale
        $slug_already_used = Post::where('slug', $slug_to_be_written)->first();

        // uso un contatore da concatenare al nome dello slug per renderlo univoco
        // comincio da 1 mapotrei aver bisogno di incrementarlo più volte se lo slug
        // che voglio scrivere già esiste nel DB
        $slug_write_attempts = 1;

        // esco dal 'while' quando ho verificato che lo slug che voglio scrivere,
        // non è già presente nel DB e posso quindi utilizzarlo
        while(!empty($slug_already_used)) {
            // costruisco lo slug che voglio scrivere
            $slug_to_be_written = $slug_from_title . '-' . $slug_write_attempts;
            // lo cerco nel DB per sapere se è già usato
            $slug_already_used = Post::where('slug', $slug_to_be_written)->first();
            // incremento il contatore che mi servirà eventualmente per costruire un altro slug
            // se quello appena creato esiste già nel DB
            $slug_write_attempts++;
        }

        // scrivo il mio slug UNIVOCO nell'oggetto da salvare nel DB
        $new_post->slug = $slug_to_be_written;

        // alla fine scrivo il nuovo oggetto nel DB
        $new_post->save();

        // faccio una REDIRECT vetso la rotta 'index'
        return redirect() -> route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // ----------- DEPENDENCY INJECTION ------------
        // questo meccanismo mi permette di non dover chiamare la find(),
        // perchè viene IMPLICITAMENTE chiamata da Laravel.
        // Io gli passo un id ma Laravel capisce che in realtà io voglio l'oggetto associato a quell'id.
        // Alla funzione show() metto come parametro in ingresso, non più un semplice id,
        // ma un oggetto di classe Post. La funzione show() viene comunque invocata passandogli
        // un 'id' (cioè un numero) ma avendo messo nella sua dichiarazione come parametro in ingresso
        // un oggetto Post, Laravel IMPLICITAMENTE chiamerà la find() e andrà a recuperare l'oggetto
        // identificato da quell'id.
        // Poi passo alla view 'show' direttamente il parametro '$post' di classe Post
        // che ho dichiarato in ingresso alla funzione stessa.
        // ATTENZIONE: il parametro deve avere lo stesso nome del Model (cioè 'post'),
        // ----------- DEPENDENCY INJECTION ------------

        // questo metodo recupera i dati di un singolo post dal DB e poi ritorna una view che
        // riceve in ingresso quello specifico post
        // il metodo riceve in ingresso l'id del post da recuperare

        // $post = Post::find($id);
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // come per la show(), uso la DEPENDENCY INJECTION. Chiamo questo metodo
        // passandolgi un id, ma ottengo un oggetto, che Laravel recupera automaticamente,
        // dal DB tramite l'id che gli passo io, e lo mette nel parametro $post,
        // che poi io uso per chiamare la view
        return view('admin.posts.edit',  ['post_to_be_edited' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // questo metodo viene chiamato dal controller quando l'utente preme sull'invio
        // del FORM sulla view 'edit', non c'è una view che viene ritornata e che
        // l'utente può vedere, è solo uno script che serve per aggiornare i dati del DB,
        // dopodichè viene fatta una REDIRECT verso la rotta 'admin.posts.index' (view principale)

        // metto i dati ricevuti tramite il parametro $request in una variabile
        $form_data_received=$request->all();

        // aggiorno il record nel DB referenziandolo con il parametro $post in ingresso alla funzione
        // (DEPENDANCY INJECTION: viene fatto un 'match' con l'id che ho passato al momento dell'invocazione)
        $post->update($form_data_received);

        // faccio una REDIRECT vetso la rotta 'index'
        return redirect() -> route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // a questo metodo non è associata nessuna view,
        // la funzione esegue una cancellazione di un record dal DB e poi fa una REDIRECT
        // verso la pagina principale
        // NOTA: anche qui come per la show(), edit(), update(), uso la DEPENDENCY INJECTION

        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
