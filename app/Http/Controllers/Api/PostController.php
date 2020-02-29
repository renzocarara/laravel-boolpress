<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    // Tutti i metodi di questo controller servono per interfacciarsi con un entità esterna
    // (un'applicazione, un sito esterno, un'app mobile, etc ) che farà una richiesta tramte l'API che io metto a disposizione
    // decido io quale sarà la risposta alla richiesta esterna.

    // Nei controller Public e Admin i metodi, lavoravano sul DB e restituivano una view,
    // l'utente (pubblico o amministratore) passava attraverso un'interfaccia grafica di visualizzazione
    // per chiedere creazioni/modifiche/letture e cancellazioni (con l'utilizzo anche di FORM per raccgliere i dati)
    // adesso invece i metodi lavorano sul DB ma restituiscono un JSON ad un chiamante esterno
    // non c'è più un'interfaccia grafica, c'è soltanto una collezione di API che vengono messe a disposizione
    // di qualcuno che sta all'esterno e che attraverso queste API può interagire col mio DB,
    // ma nel modo che decido io, in base a come scrivo le API
    // SCENARIO: possiamo immaginarci un'interfaccia tipo quella di admin su di un client remoto, dietro la quale c'è un'applicazione ,
    // che si interfaccia con noi (che siamo il server localhost:8000) e attraverso le API (cioè degli URL con specifici endpoint)
    // ci fa delle richieste per ottenere o modificare le informazioni nel nostro DB.


    // AUTENTICAZIONE DELLE API (In Laravel docs: Security - API Authentication)
    // viene utilizato un token, che deve essere inviato quando viene fatta la richiesta all'API,
    // senza cquesto API Token, il richiedente non avrà acesso alle informazioni
    // Per implementare il token devo aggiungere una colonna 'api_token' (tipo stringa di 80chars) nella tabella 'users'
    //
    // NOTA: nella cartella app\Http\Controllers\Auth file: RegisterController.php, metodo 'create()',volendo è possibile aggiungere
    // già qui il campo 'api_token' in modo che in fase di registrazione gli utenti, già abbiamo questa colonna.
    //
    //

    public function index() {
        // TESTING: per verificarla posso semplicemente scrivere nel browser: "http://localhost:8000/api/posts"
        // e dovrei vedere la risposta della mia API, cioè un file JSON con l'elenco di tutti i posts letti da DB

        // leggo tutta la tabella 'posts'
        $posts = Post::all();
        // creo la risposta, ovvero un JSON da ritornare
        // la struttura di questo response la decido io, con la struttura che voglio io
        // potrei anche passaargli direttamente $posts invece che 2 elementi con chiave, o qualsiasi altro tipo di struttura
        return response()->json(
            [
                'success' => true,
                'results' => $posts,
            ]
        );
    }

    public function show($id) {
        // TESTING: per verificarla posso semplicemente scrivere nel browser: "http://localhost:8000/api/posts/44" (richiedo il post con id=44)
        // e dovrei vedere la risposta della mia API, cioè un file JSON con il post richiesto, letto da DB

        // recupero il post richiesto tramite l'id (parametro in ingresso)
        $post = Post::find($id);
        // se l'ho trovato restituisco il post
        if($post) {
            return response()->json(
                [
                    'success' => true,
                    'results' => $post,
                ]
            );
        } else {
            // il post richiesto non esiste, ritorno un una risposta che segnala l'errore
            // e restituisce un array vuoto e un messaggio d'errore nel campo error
            return response()->json(
                [
                    'success' => false,
                    'results' => [],
                    'error' => 'Il post con id ' . $id . ' non esiste'
                ]
            );
        }
    }

    public function store(Request $request) {
        // TESTING: questo metodo riceve dei dati 'in post' a differenza della index() e della show() che lvorano 'in get',
        // per cui per testarla non posso farlo semplicemente scrivendo l'url nel browser,
        // ma ho bisogno di uno strumento tipo  "postman"
        // ESEMPIO DI CHIAMATA (CON METODO=POST) CREATA TRAMITE POSTMAN:
        // http://localhost:8000/api/posts/?title=le comete:cosa sono&author=Topolino&content=blah blahhhh&slug=le-comete-cosa-sono

        // ATTENZIONE: per mandare richieste con POSTMAN ad API che richiedono l'autenticazione, devo inserire, fra i parametri della
        // richiesta, l'API token. Ogni utente che vuole usare le API autenticate, deve avere un suo APi token.
        // Per inserirlo nella richiesta, in POSTMAN, devo selezionare la TAB: "AUTHORIZATION" e scegliere TYPE="Bearer Token" ed inserire
        // il token (stringa alfanumerica di 80chars) nel campo specifico. In alternativa posso passarglielo direttamente come parametro
        // (api_token)

        // Il metodo è POST, nella richiesta dovranno essere specificati i dati necessari per creare il post,
        // cioè 'title', 'content', 'author', 'slug', e in caso (facoltativi) 'category' e 'tags'
        // questi sono i campi che nell'interfaccia dell'admin veniva richiesti e raccolti tramite FORM,
        // qui non c'e' interfaccia, non c'e' admin, non c'e' form, c'è solo un 'attore' esterno che tramite
        // API mi fa una richiesta (in questo caso una richiesta di creazione di uno nuovo post nel DB).

        // Il fatto che  la richiesta API per creare un nuovo post, necessiti di alcuni parametri obbligatori, tipo: title, author, etc
        // sono cose che devono essere specificate nella documantazione a corredo dell'API che deve essere messa a disposizione
        // di chi poi deve usare l'API (il famoso 'attore' esterno).

        // estraggo i dati ricevuti in post,
        $dati_post = $request->all();
        // creo un nuovo oggetto da scrivere nel DB
        $nuovo_post = new Post();
        // valorizzo il nuovo oggetto
        $nuovo_post->fill($dati_post);
        // scrivo l'oggetto nel DB
        $nuovo_post->save();
        // ritorno una risposta con 'true' nel campo success e l'oggetto (post) appena scritto nel DB
        return response()->json(
            [
                'success' => true, // risultato della chiamata API
                'results' => $nuovo_post, // oggetto appena scritto nel DB
            ]
        );
    }

    public function update(Request $request, $id) {
        // TESTING:
        // ESEMPIO DI CHIAMATA (CON METODO=PUT) CREATA TRAMITE POSTMAN:
        // http://localhost:8000/api/posts/45?author=Minnie
        // richiedo di modificare l'autore del post con id=45

        // recupero il post che l'utente vuole modificare
        $post = Post::find($id);
        // se questo post esiste, procedo
        if($post) {
            // ho trovato il post, leggo i dati inviati tramite api per l'aggiornamento
            $dati_post = $request->all();
            // aggiorno i dati del post scrivendo nel DB
            // Laravel gestisce l'update() aggiornando solo i dati che (come fosse una PATCH e non PUT)
            $post->update($dati_post);
            // rispondo a chi ha invocato l?API
            return response()->json(
                [
                    'success' => true, // risultato della chiamata API
                    'results' => $post, // restituisco anche il post appena scritto
                ]
            );
        } else {
            // se non ho trovato il post richiesto all'interno del mio DB
            return response()->json(
                [
                    'success' => false, // risultato della chiamata API
                    'results' => [], // in questo caso di 'insuccesso' della chiamata, restituisco un array vuoto
                    'error' => 'Il post con id ' . $id . ' non esiste' // restituisco anche un msg di errore
                ]
            );
        }
    }

    public function destroy($id) {
        // TESTING:
        // ESEMPIO DI CHIAMATA (CON METODO=DELETE) CREATA TRAMITE POSTMAN:
        // http://localhost:8000/api/posts/47 // cancello il post con id=47

        // recupero il post che l'utente vuole cancellare
        $post = Post::find($id);
        // se il post effettivamente esiste, procedo
        if($post) {

            // verifico se c'è un'immagine associata al post
            if(!empty($post_image)) {
                // elimino l'immagine associata, viene fisicamente eliminato il file dalla cartella 'uploads'
                Storage::delete($post_image);
            }
            // siccome i 'tags' sono legati con una relazione ai 'posts' (molti a molti)
            // per poter cancellare un post devo prima 'sciogliere' questa relazione
            // la relazione nel DB è definita con un CONSTRAINT di tipo "ON DELETE: RESTRICT"
            // (e non "ON DELETE: CASCADE") quindi se provassi a cancellare un post con il vincolo ancora 'attivo',
            // non ci riuscirei ed otterrei un errore
            // verifico se ci sono tag associati al post, nel caso li cancello
            // in questo modo ora ho sganciato il post dai tags e posso poi cancellarlo
            if($post->tags->isNotEmpty()) {
                // cancello i tag associati passando alla sync un array vuoto
                $post->tags()->sync([]);
            }

            // cancello il post dal DB
            $post->delete();

            return response()->json(
                [
                    'success' => true, // restituisco 'success'
                    'results' => [], // restituisco un array vuoto
                ]
            );
        } else {
            // non ho trovato il post da cancellare
            return response()->json(
                [
                    'success' => false, // restiutisco 'false' nel campo 'success'
                    'results' => [], // potrei nche ristituire %post, cioè il post che ho cancellato, è un po'  discrezione
                                     // di solito si ritorna un array vuoto
                    'error' => 'Il post con id ' . $id . ' non esiste'
                ]
            );
        }
    }
}
