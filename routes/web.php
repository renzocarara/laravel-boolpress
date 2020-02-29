<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// utilizzo la libreria "Laravel Localization" per gestire le traduzioni, sia dell'interfaccia front-end
// che degli URI nella barra indirizzi
// (installabile da github: https://github.com/mcamara/laravel-localization)
// nel file laravellocalization.php sotto la cartella config, seleziono solo le lingue di cui voglio la traduzione
// in questo caso ho selezionato inglese (en) e italiano (it)

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localize' ]
    ], function() {
    // ROTTE PUBBLICHE:
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | /                       | public.home         | App\Http\Controllers\HomeController@index          | web          |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // HomeController pubblico (in cartella Controllers), metodo 'index' che ritorna la view 'home'
    Route::get('/', 'HomeController@index')->name('public.home'); // pagina iniziale pubblica 'root'

    // +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta     | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | contacts                | public.contacts.show | App\Http\Controllers\HomeController@contacts       | web
    // +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
    // l'URI  effettivo che apparirà nella barra si trova nel file routes.php, sotto la cartella della lingua specifica (es. 'it', 'en', etc)
    // l'espressione 'routes.contact' corrisponde ad un URI, in questo caso ad esempio, se la lingua selezionata è italiano, sarà: '/contattaci'
    Route::get(LaravelLocalization::transRoute('routes.contacts'), 'HomeController@contacts')->name('public.contacts.show');

    // +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta      | Controller @ metodo invocato                      | Middleware   |
    // +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
    // | POST      | contacts                | public.contacts.store | App\Http\Controllers\HomeController@contactsStore | web          |                                        |
    // +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
    // NOTA: l'URI di questa rotta non si vede mai nella barra indirizzi, perchè non corrisponde ad una pagina/view che viene visualizzata
    // e solo uno script che viene eseguito e poi termina con una REDIRECT (tipo le rotte di admin: store, update, destroy)
    Route::post(LaravelLocalization::transRoute('routes.contacts'), 'HomeController@contactsStore')->name('public.contacts.store');

    // +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta       | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | thankyou                | public.contacts.thanks | App\Http\Controllers\HomeController@thanks         | web          |
    // +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
    Route::get(LaravelLocalization::transRoute('routes.thankyou'), 'HomeController@thanks')->name('public.contacts.thanks');

    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | blog/page{num}           | blog                | App\Http\Controllers\PostController@index         |  web         |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // PostController pubblico (in cartella Controllers), metodo 'index' che ritorna la view 'index'
    Route::get(LaravelLocalization::transRoute('routes.blog'), 'PostController@index')->name('blog'); // pagina blog pubblica che visualizza elenco posts

    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | blog/{slug}             | post.show           | App\Http\Controllers\PostController@show           | web          |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // PostController pubblico (in cartella Controllers), metodo 'show' che ritorna la view 'show'
    Route::get(LaravelLocalization::transRoute('routes.article'), 'PostController@show')->name('post.show'); // sottopagina pubblica che visualizza 1 singolo post

    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | blog/category/{slug}  | blog.category       | App\Http\Controllers\PostController@postCategory   | web          |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    Route::get(LaravelLocalization::transRoute('routes.category'), 'PostController@postCategory')->name('blog.category');

    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | blog/tag/{slug}         | blog.tag            | App\Http\Controllers\PostController@postTag        | web          |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    Route::get(LaravelLocalization::transRoute('routes.tag'), 'PostController@postTag')->name('blog.tag');

}); // fine dichiarazione gruppo rotte pubbliche

// specifico che le rotte per la registrazione non devono essere generate
// (di default fanno parte di tutte quelle generate automaticamente da Laravel per la gestione dell'autenticazione)
Auth::routes(['register' => false]);

// ROTTE PRIVATE (cioè che richiedono autenticazione per essere accessibili):

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | admin                   | admin.home          | App\Http\Controllers\Admin\HomeController@index    | web,auth     |
    // | POST      | admin/posts             | admin.posts.store   | App\Http\Controllers\Admin\PostController@store    | web,auth     |
    // | GET|HEAD  | admin/posts             | admin.posts.index   | App\Http\Controllers\Admin\PostController@index    | web,auth     |
    // | GET|HEAD  | admin/posts/create      | admin.posts.create  | App\Http\Controllers\Admin\PostController@create   | web,auth     |
    // | DELETE    | admin/posts/{post}      | admin.posts.destroy | App\Http\Controllers\Admin\PostController@destroy  | web,auth     |
    // | PUT|PATCH | admin/posts/{post}      | admin.posts.update  | App\Http\Controllers\Admin\PostController@update   | web,auth     |
    // | GET|HEAD  | admin/posts/{post}      | admin.posts.show    | App\Http\Controllers\Admin\PostController@show     | web,auth     |
    // | GET|HEAD  | admin/posts/{post}/edit | admin.posts.edit    | App\Http\Controllers\Admin\PostController@edit     | web,auth     |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // queste rotte private sono accesibili solo da utente autenticato (middleware('auth'),
    // hanno i controllers corrispondenti (HomeController e PostController) nella cartella Controllers/Admin/ (namespace('Admin')
    // hanno tutte l'url che comincia con 'admin'(prefix('admin')),
    // hanno un nome(name) che comincia con 'admin.' (name('admin.'))
    // la 'admin.home' è quella principale, che ritorna la view 'home'
    // le altre (7, definite con ::resource()) sono quelle di default per implementare le CRUD
    Route::get('/', 'HomeController@index')->name('home'); // route principale del sito back-office
    Route::resource('/posts', 'PostController'); // routes per implementare CRUD
    // questa rotta invoca la funzione account che ritorna una view con i dettagli dell'utente (nome, cognome, etc)
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | GET|HEAD  | admin/account           | admin.account       | App\Http\Controllers\Admin\HomeController@account  | web,auth     |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    Route::get('/account', 'HomeController@account')->name('account');

    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    // +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
    Route::post('/genera-token', 'HomeController@generaToken')->name('token');

}); // fine dichiarazione gruppo rotte autenticate
