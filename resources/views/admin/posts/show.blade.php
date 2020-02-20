{{-- visualizza i dati di un singolo post --}}
@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-12">
            <h1 class="d-inline-block mb-5">Post</h1>
            <a class="btn btn-primary float-right" href="{{ route('admin.posts.index') }}">Home</a>
        </div>
    </div>
    <div class="col-12">
        <div class="row">

            <div class="card w-75 border-primary" style="width: 18rem;">
                <h5 class="card-header border-primary alert-primary">Titolo: <strong>{{ $post->title }} </strong></h5>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Autore: <strong>{{ $post->author }} </strong></h6>
                    <hr>
                    <p class="card-text">Contenuto: <strong>{{ $post->content }} </strong></p>
                    <hr>
                    <p class="card-text">slug: <strong>{{ $post->slug }}</strong></p>
                    <p class="card-text mb-0">Inserito il: <strong>{{ $post->created_at }}</strong></p>
                    <p class="card-text">Ultimo aggiornamento: <strong>{{ $post->updated_at }}</strong></p>
                    <a class="btn btn-secondary" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" class="card-link">Modifica</a>
                    <!-- Bottone che usa un modal di Bootstrap per richiedere la conferma dell'operzione di cancellazione-->
                    {{-- NOTA: il path parte dalla cartella 'views' dove si presuppone ci siano tutte le views (cioè i files .blade.php) --}}
                    @include('admin.posts.common.delete_confirmation')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection