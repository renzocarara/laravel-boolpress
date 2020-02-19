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
            <div class="card w-75" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Titolo: <strong>{{ $post->title }} </strong></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Autore: <strong>{{ $post->author }} </strong></h6>
                    <p class="card-text">Contenuto: <strong>{{ $post->content }} </strong></p>
                    <p class="card-text">slug: <strong>{{ $post->slug }}</strong></p>
                    <p class="card-text">Inserito il: <strong>{{ $post->created_at }}</strong></p>
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