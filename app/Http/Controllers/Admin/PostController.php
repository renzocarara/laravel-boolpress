<?php

// aggiungo il namespace corretto (quindi Admin)
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

// aggiungo questa 'use' per poter usare la funzione str()
use Illuminate\Support\Str;
// aggiungo questa 'use' per poter usare la funzione Storage()
use Illuminate\Support\Facades\Storage;


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

        // NOTA: dal form della view 'create', mi arriva un array associativo dove le varie chiavi
        // indirizzano i vari campi del form tra cui "cover_image_file" che è il file selezionato
        // dall'utente.
        //
        // Il file selezionato dall'utente mi arriva come
        // un oggetto di tipo 'UplodedFile' (è un 'oggettone' gestito da Laravel)
        //
        // Qui sotto il dettaglio di un'istruzione: dd($form_data_received):
        //
        // array:5 [▼
        //   "_token" => "OBG6TgnlTTDXp80wRq7HswvU2oWy4a0aAUBAMXud"
        //   "title" => "titolo di prova"
        //   "author" => "Pincopallino"
        //   "content" => "lorem ipsum bla bla bla..."
        //   "cover_image_file" => Illuminate\Http\UploadedFile {#370 ▼
        //     -test: false
        //     -originalName: "moon.jpeg"
        //     -mimeType: "image/jpeg"
        //     -error: 0
        //     #hashName: null
        //     path: "C:\Users\renzo\AppData\Local\Temp"
        //     filename: "php4F8B.tmp"
        //     basename: "php4F8B.tmp"
        //     pathname: "C:\Users\renzo\AppData\Local\Temp\php4F8B.tmp"
        //     extension: "tmp"
        //     realPath: "C:\Users\renzo\AppData\Local\Temp\php4F8B.tmp"
        //     aTime: 2020-02-21 19:14:03
        //     mTime: 2020-02-21 19:14:03
        //     cTime: 2020-02-21 19:14:03
        //     inode: 0
        //     size: 155502
        //     perms: 0100666
        //     owner: 0
        //     group: 0
        //     type: "file"
        //     writable: true
        //     readable: true
        //     executable: false
        //     file: true
        //     dir: false
        //     link: false
        //     linkTarget: "C:\Users\renzo\AppData\Local\Temp\php4F8B.tmp"
        //   }
        // ]


        // metto i dati ricevuti tramite il parametro $request in una variabile
        $form_data_received=$request->all();
        // creo un nuovo oggetto di classe Post, da scrivere poi nel DB
        $new_post = new Post();
        // valorizzo il nuovo oggetto con i dati ricevuti (ad eccezione dello 'slug' che devo calcolarlo io
        // e del percorso del file immagine, che lo tratto separatamente)
        $new_post->fill($form_data_received);

        // ----------------------------- GESTIONE FILEs -------------------------------------
        // si compone sinteticamente di 3 steps:
        // 1. l'utente seleziona un file tramite l'apposito campo del form
        // 2. recupero il path di questo file e lo passo ad una funzione 'put' che ne fa una copia in una cartella ('uploads')
        // della mia applicazione e in più mi restituise il percorso di dove ha messo questa copia
        // 3. salvo nel DB, nell'apposita colonna che ho creato (cover_image), il percorso del file
        //
        // verifico che l'elemento 'cover_image_file' ricevuto dal form non sia vuoto
        // accedo all'array con la chiave associativa ('cover_image_file') che identifica quell'elemento
        // è l'attributo 'name' del tag <input> del form che ha ricevuto il nome del file selezionato dall'utente
        if(!empty($form_data_received['cover_image_file'])) {
            // estraggo il percorso del file selezionato dall'utente tramite il form della view 'create'
            $cover_image = $form_data_received['cover_image_file'];
            // la cartella 'uploads', la creo io e conterrà i files che carica l'utente, verrà creata sotto storage\app\public\
            // passo alla funzione 'put' 2 parametri:
            // la cartella ('uploads') dove mettere il file  il percorso ('$cover_image') da dove prendere il file
            // la 'put', oltre a fare la copia  del file, mi restituisce il path di dove ha salvato il file, scriverò questo path nel DB
            $cover_image_path = Storage::put('uploads', $cover_image);

            // inserico nell'oggetto $new_post il path ottenuto, poi dopo l'oggetto $new_post lo salvo nel DB
            $new_post->cover_image = $cover_image_path;
        }
        // ------------------------------ GESTIONE FILEs -------------------------------------


        // ------------------------------ GESTIONE SLUG -------------------------------------
        // calcolo uno slug univoco, verificando se già esiste quello che voglio scrivere
        // ricavo lo slug teorico che dovrei scrivere, in base al titolo del post
        $slug_from_title = Str::slug($form_data_received['title']);
        // mi salvo lo slug 'potenziale' in una variabile
        $slug_to_be_written = $slug_from_title;
        // ora verifico che nel db non esista uno slug uguale
        $slug_already_used = Post::where('slug', $slug_to_be_written)->first();

        // uso un contatore da concatenare al nome dello slug per renderlo univoco
        // comincio da 1 ma potrei aver bisogno di incrementarlo più volte se lo slug
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
        // ------------------------------ GESTIONE SLUG -------------------------------------

        // scrivo il mio slug UNIVOCO nell'oggetto da salvare nel DB
        $new_post->slug = $slug_to_be_written;

        // alla fine scrivo il nuovo oggetto nel DB
        $new_post->save();

        // faccio una REDIRECT verso la rotta 'index'
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

        // $post = Post::find($id); // questa riga non serve perchè uso la dependency injection
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
        // passandogli un id, ma ottengo un oggetto, che Laravel recupera automaticamente,
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

        // NOTA: in $post ho il record da aggiornare (che Laravel ha letto implicitamente dal DB,
        // ricevendo in ingresso l'id del post)

        // metto in una variabile i nuovi dati da scrivere, ricevuti tramite il parametro $request
        $form_data_received=$request->all();

        // ----------------------------- GESTIONE FILEs -------------------------------------
        // si compone sinteticamente di 3 steps:
        // 1. l'utente seleziona un file tramite l'apposito campo del form
        // 2. recupero il path di questo file e lo passo ad una funzione 'put' che ne fa una copia in una cartella ('uploads')
        // della mia applicazione Laravel e in più mi restituise il percorso di dove ha messo questa copia
        // 3. inserisco il nuovo path nell'oggetto che userò per fare l'update del DB
        //
        // verifico che il campo cover_image_file ricevuto dal form non sia vuoto
        if(!empty($form_data_received['cover_image_file'])) {

            // se il post aveva già un'immagine associata, la cancello prima di collegare quella nuova
            if(!empty($post->cover_image)) {
                // cancello l'immagine precedente, viene fisicamente eliminato il file dalla cartella 'uploads'
                Storage::delete($post->cover_image);
            }

            // estraggo il percorso del file selezionato dall'utente
            $cover_image = $form_data_received['cover_image_file'];
            // passo alla funzione 'put' 2 parametri:
            // la cartella ('uploads') dove mettere il file e il percorso ('$cover_image') da dove prendere il file
            // la 'put', oltre a fare la copia del file, mi restituisce il path di dove ha salvato il file
            $cover_image_path = Storage::put('uploads', $cover_image);

            // inserico il nuovo path fornitomi dalla funzione 'put' nell'oggetto che contiene i dati da aggiornare
            // $form_data_received['cover_image'] = $cover_image_path;
            $post->cover_image = $cover_image_path;
        }
        // ------------------------------ GESTIONE FILEs -------------------------------------

        // aggiorno il record nel DB referenziandolo con il parametro $post in ingresso alla funzione
        // (DEPENDANCY INJECTION: viene fatto un 'match' con l'id che ho passato al momento dell'invocazione
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

        // eseguo la cancellazione de file immagine che si trova nella cartella 'uploads'
        $post_image = $post->cover_image;
        Storage::delete($post_image);

        // cancello il record (post) dalla tabella del DB
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
