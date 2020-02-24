{{-- view 'index' pubblica per visualizzare elenco posts --}}
{{-- riceve in ingresso la collection di posts letta dal DB dal metodo 'index', --}}
{{-- del controller pubblico 'PostController' --}}
@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="d-inline-block">Tutti i post (<strong>{{ $total_posts_in_DB }}</strong>)</h1>

            {{-- scorro i posts e ne visualizzo solo i titoli --}}
            @forelse ($posts_in_the_page as $post)
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

            <h4 class="d-inline-block">Pagina <strong>{{ $page_num }}</strong></h4>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- se sono sulla prima pagina disabilito il pulsante 'previous' --}}
                    <li class="page-item {{ $page_num == 1 ? 'disabled' : '' }}">
                        <a class="page-link border-primary" href="{{ route('blog', $page_num - 1) }}">Previous</a>
                    </li>
                    {{-- se sono sull'ultima pagina disabilito il pulsante 'next' --}}
                    <li class="page-item {{ ($page_num == ceil($total_posts_in_DB/$max_posts_per_page)) ? 'disabled' : '' }}">
                        <a class="page-link border-primary" href="{{ route('blog', $page_num + 1) }}">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
@endsection