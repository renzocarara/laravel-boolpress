@extends('layouts.admin')

{{-- imposto il titolo della pagina --}}
@section('page-title', "BoolPress - Inserisci nuovo post")

@section('content')

<main>

    <section class="container">

        <h2 class="d-inline-block">Inserimento nuovo post</h2>
        <a class="btn btn-primary float-right" href="{{ route('admin.posts.index') }}">Home</a>

        <div class="d-flex">
            {{-- al submit chiamo la route 'store' che non corrisponde ad una view da visualizzare, --}}
            {{-- ma è solo del codice che elabora i dati del form e crea un oggetto Post da scrivere nel DB --}}

            {{-- NOTA: perchè il form possa gestire anche i file bisogna aggiungere questo attributo:
                 enctype="multipart-form-data" --}}
            <form class="w-100" enctype="multipart/form-data" method="post" action="{{ route('admin.posts.store') }}">

                @csrf

                <div class="form-group">
                    <label for="title">Titolo:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="titolo del post" required>
                </div>
                <div class="form-group">
                    <label for="author">Autore:</label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="nome dell'autore" required>
                </div>
                <div class="form-group">
                    <label for="text">Testo:</label>
                    <textarea class="form-control" id="text" rows=8 name="content" placeholder="scrivi qui il tuo articolo..." required></textarea>
                </div>
                {{-- questo campo serve per la selezione del file immagine, l'attributo 'type' dell'<input> è "file" --}}
                <div class="form-group">
                    <label for="cover_image_file">Immagine di copertina:</label>
                    <input type="file" class="form-control-file" id="cover_image_file" name="cover_image_file">
                </div>
                <button type="submit" class="btn btn-success">Crea</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>

        </div>

    </section>

</main>

@endsection