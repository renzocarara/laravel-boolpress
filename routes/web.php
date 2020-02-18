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
// HomeController pubblico (in cartella Controllers), metodo 'index' che ritorna la view 'homepage'
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// | Domain | Method    | URI                     | Name                | Action                                                                 | Middleware   |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// |        | GET|HEAD  | /                       | public.home         | App\Http\Controllers\HomeController@index                              | web          |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
Route::get('/', 'HomeController@index')->name('public.home'); // pagina iniziale pubblica

// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// | Domain | Method    | URI                     | Name                | Action                                                                 | Middleware   |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// |        | GET|HEAD  | blog                    | blog                | App\Http\Controllers\PostController@index                              | web          |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// PostController pubblico (in cartella Controllers), metodo 'index'
Route::get('/blog', 'PostController@index')->name('blog'); // sottopagina blog pubblica che visualizza elenco posts

// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// | Domain | Method    | URI                     | Name                | Action                                                                 | Middleware   |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// |        | GET|HEAD  | blog/{slug}             | blog.show           | App\Http\Controllers\PostController@show                               | web          |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// PostController pubblico (in cartella Controllers), metodo 'show'
Route::get('/blog/{slug}', 'PostController@show')->name('blog.show'); // sottopagina pubblica che visualizza 1 singolo post

Auth::routes();

// ROTTE PRIVATE:
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// | Domain | Method    | URI                     | Name                | Action                                                                 | Middleware   |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// |        | GET|HEAD  | admin                   | admin.home          | App\Http\Controllers\Admin\HomeController@index                        | web,auth     |
// |        | POST      | admin/posts             | admin.posts.store   | App\Http\Controllers\Admin\PostController@store                        | web,auth     |
// |        | GET|HEAD  | admin/posts             | admin.posts.index   | App\Http\Controllers\Admin\PostController@index                        | web,auth     |
// |        | GET|HEAD  | admin/posts/create      | admin.posts.create  | App\Http\Controllers\Admin\PostController@create                       | web,auth     |
// |        | DELETE    | admin/posts/{post}      | admin.posts.destroy | App\Http\Controllers\Admin\PostController@destroy                      | web,auth     |
// |        | PUT|PATCH | admin/posts/{post}      | admin.posts.update  | App\Http\Controllers\Admin\PostController@update                       | web,auth     |
// |        | GET|HEAD  | admin/posts/{post}      | admin.posts.show    | App\Http\Controllers\Admin\PostController@show                         | web,auth     |
// |        | GET|HEAD  | admin/posts/{post}/edit | admin.posts.edit    | App\Http\Controllers\Admin\PostController@edit                         | web,auth     |
// +--------+-----------+-------------------------+---------------------+------------------------------------------------------------------------+--------------+
// queste rotte private (accesibili cioè solo da utente autenticato),
// hanno i controllers corrispondenti (HomeController e PostController) nella cartella Controllers/Admin/
// Hanno tutte l'url che cominciano con 'admin', hanno un name che comincia con 'admin.'
// la admin.home è quella principale, che ritorna la view 'home'
// le altre (7) sono quelle di default per implementare le CRUD
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function() {
    Route::get('/', 'HomeController@index')->name('home'); // route principale
    Route::resource('/posts', 'PostController'); // routes per implementare CRUD
});