@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="d-inline-block mb-5">Tutti i post con tag: <strong><em>{{ $tag->name }}</em></strong> ({{$posts->count()}})</h1>
            <a class="btn btn-primary float-right" href="{{ route('blog') }}">Blog</a>

            @forelse ($posts as $post)

            <div class="alert alert-primary" role="alert">
                {{-- posso visualizzare i dettagli del singolo post cliccandoci sopra,
                {{-- viene chiamata la route post.show che  --}}
                {{-- prende in ingresso come parametro lo slug del post --}}
                <a href="{{ route('post.show', ['slug' => $post->slug]) }}">
                    {{ $post->title }}
                </a>
            </div>

            @empty
            <div class="alert alert-warning" role="alert">
                ATTENZIONE: non ci sono post da visualizzare!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection