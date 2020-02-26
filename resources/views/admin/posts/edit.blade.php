@extends('layouts.admin')

{{-- imposto il titolo della pagina --}}
@section('page-title', "BoolPress - Modifica Post")

@section('content')

<main>

    <section class="container">

        <h2 class="d-inline-block">Modifica post</h2>
        <a class="btn btn-primary float-right" href="{{ route('admin.posts.index') }}">Home</a>

        <div class="">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- al submit chiamo la route 'store' che non corrisponde ad una view da visualizzare, --}}
            {{-- ma è solo del codice che elabora i dati del form e crea un oggetto Post da scrivere nel DB --}}
            {{-- quando ho raccolto i dati dal form richiamo la route 'update' passandogli l'id del post da aggiornare --}}
            <form class="w-100" enctype="multipart/form-data" method="post" action="{{ route('admin.posts.update', $post_to_be_edited->id) }}">

                @csrf
                @method('PUT') {{-- il form prvede solo i metodi GET o  POST, con questa direttiva gli secifico che voglio PUT --}}
                {{-- nell'attributo value mostro l'old (cioè il valore inserito dall'utente e precedente all'errore), se non c'è un valore 'old', mostro il valore originale letto dal DB --}}
                <div class="form-group">
                    <label for="title">Titolo:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="titolo del post" value="{{ old('title', $post_to_be_edited->title) }}">
                </div>
                <div class="form-group">
                    <label for="author">Autore:</label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="nome dell'autore" value="{{ old('author', $post_to_be_edited->author) }}">
                </div>
                <div class=" form-group">
                    <label for="text">Testo:</label>
                    <textarea class="form-control" id="text" rows=8 name="content" placeholder="scrivi qui il tuo articolo...">{{ old('content', $post_to_be_edited->content) }}</textarea>
                </div>
                {{-- questo campo serve per la selezione del file immagine, l'attributo 'type' dell'<input> è "file" --}}
                <div class="form-group">
                    <label for="cover_image_file">Immagine corrente del post:</label>
                    {{-- verifico se il post da modificare ha un'immagine associata --}}
                    @if ($post_to_be_edited->cover_image)
                    {{-- visualizzo l'immagine associata corrente --}}
                    <div class="post-image">
                        {{-- asset mi indirizza nella cartella public sotto la root principale del progetto --}}
                        {{-- in public però ho creato un symlink che mi ridirige a dove il file è effettivamente memorizzato: --}}
                        {{-- cioè in storage\app\public\uploads --}}
                        <img class="img-fluid mb-3" src="{{ asset('storage/' . $post_to_be_edited->cover_image) }}" alt="{{ $post_to_be_edited->title }} - immagine del post">
                    </div>
                    @endif
                    <input type="file" class="form-control-file mb-5" id="cover_image_file" name="cover_image_file">
                </div>

                <div>
                    {{-- verifico che ci sia almeno 1 tipo di categoria letta dal DB --}}
                    @if ($categories->count() > 0)
                    <select class="form-group" name="category_id">
                        <option value="">Seleziona la categoria</option>
                        {{-- scorro l'elenco di tutte le categorie recuperate dalla tabella 'categories', --}}
                        {{-- questo elenco mi è arrivato come parametro in ingresso quando ho chiamato questa view --}}
                        @foreach ($categories as $category)
                        {{-- popolo le <option> con le categorie ricevute in ingresso a questa view --}}
                        {{-- nella stringa da visualizzare metto il nome della categoria --}}
                        {{-- nell'attributo 'value' metto l'id della categoria --}}


                        {{-- verifico se l'utente aveva selezionato una voce nella 'select' --}}
                        <option @if (!empty(old('category_id')))
                            {{-- se sì, vado a veder se questa voce selezinata precedentemente dall'utente è uguale
                            alla voce che sto inserendo nell'elenco delle option della select
                            se sì, la imposto come voce 'selected' in modo che appaia come voce selezionata della select --}}
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                        @else
                            {{-- verifico se il post ha una categoria associata ($post_to_be_edited->category) e poi --}} --}}
                            {{-- se la categoria di cui sto valorizzando la option ($category->id),  --}}
                            {{-- corrisponde alla categoria del post da editare ($post_to_be_edited->category->id)
                                 nel caso la visualizzo come selezionata --}}
                        {{ ($post_to_be_edited->category && ($post_to_be_edited->category->id == $category->id)) ? 'selected' : '' }}
                        @endif
                        value="{{ $category->id }}">
                        {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                        {{-- non ci sono categorie nella tabella 'categories' del DB, --}}
                        {{-- bisognerebbe predisporre una pagina, lato admin, per permettere all'utente di crearne --}}
                    <a href="#">Aggiungi la prima categoria</a>
                    @endif
                </div>

                <div class="">
                    @if($tags->count() > 0)
                        <p>Seleziona i tags per questo post:</p>
                        @foreach ($tags as $tag)
                        <label for="tag_{{ $tag->id }}">
                            <input id="tag_{{ $tag->id }}" type="checkbox"
                            @if($errors->any())
                                {{-- se ci sono stati degli errori al submit, la pagina viene ricaricata,
                                verifico se il tag che sto scrivendo/ciclando è uno di quelli che l'utente aveva checkato precedentemente,
                                (lo faccio controllando l'array tag_id con la funzione in_array())
                                se sì, aggiungo 'checked' in modo che appaia come checkato --}}
                                {{ in_array($tag->id, old('tag_id', array())) ? 'checked' : '' }}
                            @else
                                {{-- la funzione contains() verifica se nei tag associati a questo post (cioè nella collection: $post_to_be_edited->tags)  --}}
                                {{-- è contenuto il tag che sto ciclando in questo momento (col foreach sto ciclando l'elenco completo letto da DB di tutti i tipi di tag ) --}}
                                {{-- se sì, aggiungo 'checked' e il tag verrà visualizzato come 'checkato', altrimenti non aggiungo niente --}}
                                {{ ($post_to_be_edited->tags)->contains($tag) ? 'checked' : '' }}
                            @endif
                            name="tag_id[]" value="{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                        @endforeach
                        @endif
                </div>

                <button type="submit" class="btn btn-success">Aggiorna</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>

        </div>

    </section>

</main>

@endsection
