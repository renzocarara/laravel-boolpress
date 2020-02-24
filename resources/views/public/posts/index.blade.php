{{-- view 'index' pubblica per visualizzare elenco posts --}}
{{-- riceve in ingresso la collection di posts letta dal DB dal metodo 'index', --}}
{{-- del controller pubblico 'PostController' --}}
@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="d-inline-block">Tutti i post (<strong>{{ $total_posts }}</strong>)</h1>

            {{-- scorro i posts e ne visualizzo solo i titoli --}}
            @forelse ($posts as $post)
            {{-- rendo i titoli dei link cliccabili per avere il dettaglio completo del post --}}
            {{-- al click sul link richiamo la route pubblica 'post.show' che invoca --}}
            {{-- il metodo show() che riceve in ingresso il parametro $slug e richiama --}}
            {{-- a sua volta la view 'show' --}}
            <div class="alert alert-primary" role="alert">
                <a href="{{ route('post.show', ['slug' => $post->slug]) }}">
                    {{ $post->title }}
                </a>
            </div>

            @empty
            <div class="alert alert-warning" role="alert">
                ATTENZIONE: non ci sono post da visualizzare!
            </div>
            @endforelse

            {{-- paginazione fatta automaticamente da Laravel --}}
            {{ $posts->links() }}

        </div>
    </div>
</div>
@endsection