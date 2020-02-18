{{-- view 'index' pubblica per visualizzare elenco posts --}}
{{-- riceve in ingresso la collection di posts letta dal DB dal metodo 'index', --}}
{{-- del controller pubblico 'PostController' --}}
@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Tutti i post</h1>
            <ul>
                {{-- scorro i posts e ne visualizzo solo i titoli --}}
                {{-- rendo i titoli dei link cliccabili per avere il dettaglio completo del post --}}
                @forelse ($posts as $post)
                {{-- al click sul link richiamo la route pubblica 'blog.show' che invoca --}}
                {{-- il metodo show() che riceve in ingresso il parametro $slug e richiama --}}
                {{-- a sua volta la view 'single-post' --}}
                <li><a href="{{ route('blog.show', [ 'slug' => $post->slug ]) }}">
                        {{ $post->title }}
                    </a></li>
                @empty
                <li>Non ci sono ancora post</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection