{{-- view 'show' pubblica per visualizzare un singolo post --}}
{{-- riceve in ingresso il parametro 'post' che corrisponde allo slug del post cliccato dall'utente --}}

@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="d-inline-block mb-5">Post</h1>
            <a class="btn btn-primary float-right" href="{{ route('blog', 1) }}">Blog</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card w-75 border-primary" style="width: 18rem;">
                <h5 class="card-header border-primary alert-primary">Titolo: <strong>{{ $post->title }} </strong></h5>
                <div class="card-body">
                    {{-- verifico se il post ha un'immagine associata, se sì la visualizzo --}}
                    @if (!empty($post->cover_image))
                    <div class="post-image mb-4">
                        <img class="img-fluid " src="{{ asset('storage/' . $post->cover_image) }}" class="card-img-top" alt="{{ $post->title }} - immagine del post">
                    </div>
                    @endif
                    <h6 class="card-subtitle mb-2">Autore: <strong>{{ $post->author }} </strong></h6>
                    <hr>
                    <p class="card-text">Contenuto: <strong>{{ $post->content }} </strong></p>
                    <hr>
                    <p class="card-text mb-0">Inserito il: <strong>{{ $post->created_at }}</strong></p>
                    <p class="card-text">Ultimo aggiornamento: <strong>{{ $post->updated_at }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection