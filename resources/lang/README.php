//
// COME FUNZIONA:
// nei file blade.php andrò a sostituire il testo da tradurre con una chiamata alla funzione di traduzione __(),
// (in alternativa esiste anche la notazione "@lang()" anzichè "__()")
// con questa sintassi: {{ __('nome_file.nome_della_chiave') }}
// ad esempio: {{ __('messages.account_details_title') }}
// dove 'messages' è il nome del file e 'account_details_title' e la chiave con cui accedo all'elemento dell'array
// che mi fornisce il testo tradotto nella lingua specifica. L'array è definito nei files sotto:
// resources/lang/en ...it ...es ...fr ...de etc. Posso creare le cartelle che voglio per le lingue che voglio.
//
// IMPOSTARE LA LINGUA DI DEFAULT DA FILE DI CONFIGURAZIONE
// Nel file app.php sotto la cartella config vengono definiti la lingua di default
// da utilizzare e la lingua "di riserva" (fallback) nel caso quella di default non venga trovata
// bisogna quindi impostare le 2 seguenti variabili con il nome della cartella della lingua che vogliamo:
// 'locale' => 'en',  // questo imposta la lingua di default
// 'fallback_locale' => 'en', // questo imposta la lingua alternativa
//
// IMPOSTARE LA LINGUA DI DEFAULT DAL CODICE
// la lingua da usare per una determinata view può anche essere impostata direttamente nel codice,
// (quindi nel nostro controller) dando la seguente istruzione:
// App::setLocale($locale); // se vogliamo usare la variabile locale settata nel file app..php,
// oppure passando direttamente il nome della cartella da utilizzare:
// App::setLocale('it'); // ad esempio per impostare italiano (cartella 'it')
// (ricordarsi di aggiungere la "use App" in cima al controller per fargli 'vedere' la classe)
// NOTA:
// la variabile $locale può anche essere passata nello slug della route:
// Route::get('welcome/{locale}', function ($locale) {
//    App::setLocale($locale);
// });
//
// UTILIZZO DI PLACEHOLDER NEL TESTO DA TRADURRE
// E' possibile inserire dei placeholder che al momento di costruire il testo da visualizzare verranno
// sostituiti con un valore. Si usa la seguente notazione:
// ad esempio nel file delle traduzioni scriviamo:
// 'account_subtitle' => 'Ciao :name!',
// dove :name è un placeholder che verrà sostituito da un valore,
// e nel file .blade dove andiamo a richiamare la funzione di traduzione, scriviamo:
//  __('messages.account_subtitle', ['name' => 'Renzo']);
// gli passiamo cioè il parametro da usare al posto del placeholder
//
// ALTERNATIVA AL SETTARE LA LINGUA DA FILE DI CONFIG O CODICE: USARE LA LIBRERIA "LARAVELLOCALIZATION"
// "Laravel Localization":
// (installabile da github: https://github.com/mcamara/laravel-localization seguendo le istruzioni)
// > composer require mcamara/laravel-localization
// > php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
// nel file laravellocalization.php sotto la cartella config, seleziono solo le lingue di cui voglio la traduzione
// in questo caso ho selezionato inglese (en) e italiano (it)
//
// in questo modo, digitando localhost:8000\it oppure localhost:8000\en dovrei ottenere le 2 versioni della pagina
// in italiano o in inglese, la selezione della lingua, ovviamente deve avvenire tramite menu e non digitando un url,
// vedi sotto.
//
// SELETTORE LINGUA (DA FRONT-END)
// inserire il codice:
// <ul>
//     @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
//         <li>
//             <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
//                 {{ $properties['native'] }}
//             </a>
//         </li>
//     @endforeach
// </ul>
//
// questo codice legge nel file: laravellocalization.php sotto la cartella '/config',
// dove c'è un solito array e per ogni lingua alcune chiavi con dei valori che ne definiscono delle caratteristiche,
// posso anche aggiungere delle mie chiavi personalizzate, devo ricordarmi però di aggiungerle su tutti
// gli elementi dell'array (che sono poi le varie lingue)
//

// NOTA: invece che tradurre i file di "default" di Laravel: auth.php, passwords.php, validation.php, pagination.php,
// si può scaricarli  da qui https://github.com/albertosabena/laravel-italian-language-pack (o cercare su google!)

// NOTA: anzichè usare degli array con dentro gli elementi chiave=>traduzione, è possibile usare direttamente
// delle stringhe come fossere le chiavi, definendo un file JSON (sempre sotto resources/lang, come questo:

// {
//    "I love programming.": "Amo programmare."
// }

// TRADUZIONE DEGLI 'URI' CHE APPAIONO NELLA BARRA INDIRIZZI (QUINDI DELLE ROTTE)
// nel file: app\Http\kernel.php è definito un array: $routeMiddleware,
// bisogna aggiungerci almeno il middleware 'localize' della libreria che abbiamo installato precedentemente
// (Laravel Locatization) (nota: la libreria ne mette a disposizione anche altri)
// aggiungo il middleware 'localize' nel file web.php, sul gruppo delle rotte che volglio tradurre:
// 'middleware' => [ 'localize' ]
// creo un file routes.php dentro ogni cartella che contiene le traduzioni (es. 'en', 'it', 'fr', etc)
// il file è fatto così, un array associativo:
//
// // resources/lang/it/routes.php
// return [
//     'contacts' => 'contattaci',
//     'thankyou' => 'grazie',
//     'blog' => 'articoli',
//     'article' => 'articoli/{slug}',
//     'category' => 'articoli/categoria/{slug}',
//     'tag' => 'articoli/tag/{slug}'
// ];

// chiave => valore
// dove:
// chiave: corrisponde al parametro della transRoute() nel file delle rotte web.php
// valore: corrisponde all'URI visualizzato nella barra indirizzi

// nel file web.php sostituisco l'URI
// ad esempio:
// '/blog/tag/{slug}'
// con:
// LaravelLocalization::transRoute('routes.tag')
// dove l'espressione 'routes.tag' è definita nel file route.php che ho creato sotto la cartella lang
