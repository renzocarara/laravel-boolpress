{{-- view 'single-post' pubblica per visualizzare un singolo post --}}
{{-- riceve in ingresso il parametro 'post' che corrisponde allo slug del post cliccato dall'utente --}}

@extends('layouts.public')

@section('content')
<div class="container">

    <div class="col-12">
        <div class="row mt-4">
            <h1>Post</h1>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="card w-75" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Titolo: <strong>{{ $post->title }} </strong></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Autore: <strong>{{ $post->author }} </strong></h6>
                    <p class="card-text">Contenuto: <strong>{{ $post->content }} </strong></p>
                    <p class="card-text">Inserito il: <strong>{{ $post->created_at }}</strong></p>
                    <p class="card-text">Ultimo aggiornamento: <strong>{{ $post->updated_at }}</strong></p>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection