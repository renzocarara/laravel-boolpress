{{-- view 'single-post' pubblica per visualizzare un singolo post --}}
{{-- riceve in ingresso il parametro 'post' che corrisponde allo slug del post cliccato dall'utente --}}

@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>{{ $post->title }}</h1>
            <div>
                {{-- visualizzo il contenuto del post richiesto --}}
                <p>Testo: <em>{{ $post->content }}</em></p>
                {{-- visualizzo l'autore del post richiesto --}}
                <p>Autore: <em>{{ $post->author }}</em></p>
            </div>
        </div>
    </div>
</div>
@endsection