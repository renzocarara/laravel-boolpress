{{-- view 'index' pubblica per visualizzare elenco posts --}}
{{-- riceve in ingresso la collection di posts letta dal DB dal metodo 'index', --}}
{{-- del controller pubblico 'PostController' --}}
@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1>Tutti i post</h1>

            @php
            // flag che mi indica che ho già visualizzato l'ultima pagina di post
            $no_post_to_display = false;
            @endphp

            <ul>
                {{-- scorro i posts e ne visualizzo solo i titoli --}}
                @forelse ($posts as $post)
                {{-- rendo i titoli dei link cliccabili per avere il dettaglio completo del post --}}
                {{-- al click sul link richiamo la route pubblica 'blog.show' che invoca --}}
                {{-- il metodo show() che riceve in ingresso il parametro $slug e richiama --}}
                {{-- a sua volta la view 'show' --}}
                <li><a href="{{ route('blog.show', [ 'slug' => $post->slug ]) }}">
                        {{ $post->title }}
                    </a>
                </li>

                @empty
                <li>
                    <div class="alert alert-warning" role="alert">
                        Non ci sono post!
                    </div>
                </li>
                @php
                // setto il flag ad indicare che non ci sono più post da visualizzare
                $no_post_to_display = true;
                @endphp
                @endforelse
            </ul>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- se sono sulla prima pagina dei post disabilito il pulsante 'previous' --}}
                    <li class="page-item {{ $from == 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ route('blog', ['from' => ($from - 3), 'direction' => 'previous']) }}">Previous</a>
                    </li>
                    {{-- se non ci sono post da visualizzare disabilito il pulsante 'next' --}}
                    <li class="page-item {{ ($no_post_to_display==true) ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ route('blog', ['from' => ($from + 3), 'direction' => 'next']) }}">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
@endsection