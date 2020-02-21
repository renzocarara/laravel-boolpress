@extends('layouts.admin')

{{-- imposto il titolo della pagina --}}
@section('page-title', "BoolPress - Modifica Post")

@section('content')

<main>

    <section class="container">

        <h2 class="d-inline-block">Modifica post</h2>
        <a class="btn btn-primary float-right" href="{{ route('admin.posts.index') }}">Home</a>

        <div class="d-flex">
            {{-- al submit chiamo la route 'store' che non corrisponde ad una view da visualizzare, --}}
            {{-- ma è solo del codice che elabora i dati del form e crea un oggetto Post da scrivere nel DB --}}
            {{-- quando ho raccolto i dati dal form richiamo la route 'update' passandogli l'id del post da aggiornare --}}
            <form class="w-100" enctype="multipart/form-data" method="post" action="{{ route('admin.posts.update', $post_to_be_edited->id) }}">

                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Titolo:</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $post_to_be_edited->title }}" placeholder="titolo del post" required>
                </div>
                <div class="form-group">
                    <label for="author">Autore:</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ $post_to_be_edited->author }}" placeholder="nome dell'autore" required>
                </div>
                <div class="form-group">
                    <label for="text">Testo:</label>
                    <textarea class="form-control" id="text" rows=8 name="content" placeholder="scrivi qui il tuo articolo..." required>{{ $post_to_be_edited->content }}</textarea>
                </div>
                {{-- questo campo serve per la selezione del file immagine, l'attributo 'type' dell'<input> è "file" --}}
                <div class="form-group">
                    <label for="cover_image_file">Immagine corrente del post:</label>
                    {{-- verifico se il post da modificare ha un'immagine associata --}}
                    @if ($post_to_be_edited->cover_image)
                    {{-- visualizzo l'immagine associata corrente --}}
                    <div class="post-image">
                        <img class="img-fluid mb-3" src="{{ asset('storage/' . $post_to_be_edited->cover_image) }}" alt="{{ $post_to_be_edited->title }} - immagine del post">
                    </div>
                    @endif
                    <input type="file" class="form-control-file mb-5" id="cover_image_file" name="cover_image_file">
                </div>
                <button type="submit" class="btn btn-success">Aggiorna</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>

        </div>

    </section>

</main>

@endsection