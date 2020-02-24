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
// ROTTE PUBBLICHE:
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | /                       | public.home         | App\Http\Controllers\HomeController@index          | web          |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// HomeController pubblico (in cartella Controllers), metodo 'index' che ritorna la view 'home'
Route::get('/', 'HomeController@index')->name('public.home'); // pagina iniziale pubblica

// +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta     | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | contacts                | public.contacts.show | App\Http\Controllers\HomeController@contacts       | web
// +-----------+-------------------------+----------------------+----------------------------------------------------+--------------+
Route::get('/contacts', 'HomeController@contacts')->name('public.contacts.show');

// +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta      | Controller @ metodo invocato                      | Middleware   |
// +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
// | POST      | contacts                | public.contacts.store | App\Http\Controllers\HomeController@contactsStore | web          |                                        |
// +-----------+-------------------------+-----------------------+---------------------------------------------------+--------------+
Route::post('/contacts', 'HomeController@contactsStore')->name('public.contacts.store');

// +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta       | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | thankyou                | public.contacts.thanks | App\Http\Controllers\HomeController@thanks         | web          |
// +-----------+-------------------------+------------------------+----------------------------------------------------+--------------+
Route::get('/thankyou', 'HomeController@thanks')->name('public.contacts.thanks');

// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | blog/page{num}           | blog                | App\Http\Controllers\PostController@index         |  web         |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// PostController pubblico (in cartella Controllers), metodo 'index' che ritorna la view 'index'
Route::get('/blog/page/{num}', 'PostController@index')->name('blog'); // sottopagina blog pubblica che visualizza elenco posts

// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | blog/{slug}             | post.show           | App\Http\Controllers\PostController@show           | web          |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// PostController pubblico (in cartella Controllers), metodo 'show' che ritorna la view 'show'
Route::get('/blog/{slug}', 'PostController@show')->name('post.show'); // sottopagina pubblica che visualizza 1 singolo post

// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | Method    | URI in barra indirizzi  | Nome della rotta    | Controller @ metodo invocato                       | Middleware   |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
// | GET|HEAD  | blog/categories/{slug}  | blog.category       | App\Http\Controllers\PostController@postCategory   | web          |
// +-----------+-------------------------+---------------------+----------------------------------------------------+--------------+
Route::get('/blog/categories/{slug}', 'PostController@postCategory')->name('blog.category');


// ROTTE PRIVATE:
// specifico che le rotte per la registrazione non devono essere generate
// (di default fanno parte di tutte quelle generate automaticamente da Laravel per la gestione dell'autenticazione)
Auth::routes(['register' => false]);

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
// queste rotte private (accesibili cioè solo da utente autenticato),
// hanno i controllers corrispondenti (HomeController e PostController) nella cartella Controllers/Admin/
// Hanno tutte l'url che comincia con 'admin', hanno un name che comincia con 'admin.'
// la 'admin.home' è quella principale, che ritorna la view 'home'
// le altre (7) sono quelle di default per implementare le CRUD
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('home'); // route principale del sito back-office
    Route::resource('/posts', 'PostController'); // routes per implementare CRUD
});
