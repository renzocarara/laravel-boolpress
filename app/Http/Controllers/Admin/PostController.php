<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
