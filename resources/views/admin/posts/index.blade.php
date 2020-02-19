 {{-- url: 'admin/posts'
 nome route: 'admin.posts.index'
 nome view: 'index' (nella cartella views/admin/posts/)
 controller:  'PostController' (nella cartella Controllers\Admin\)
 metodo che la richiama: 'index'  --}}

 {{-- Questa pagina visualizza tutti i posts recuperati dal DB --}}
 {{-- la view riceve infatti un parametro in ingresso (post) che rappresenta la collection --}}
 {{-- dei dati letti dal DB (dal metodo PostController@index) --}}
 {{-- Tramite i pulsanti nella colonna Azioni, sarà possibile eseguire delle CRUD sui posts --}}

 @extends('layouts.admin')

 @section('content')
 <div class="container">
     <div class="row">
         <div class="col-12">
             <h1 class="d-inline-block mb-5">Tutti i post</h1>
             <a class="btn btn-primary float-right" href="{{ route('admin.posts.create') }}">Crea nuovo Post</a>
         </div>
     </div>
     <div class="row">
         <div class="col-12">
             <table class="table">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Titolo</th>
                         <th>Slug</th>
                         <th>Autore</th>
                         <th>Azioni</th>
                     </tr>
                 </thead>
                 <tbody>
                     @forelse ($posts as $post)
                     <tr>
                         <td>{{ $post->id }}</td>
                         <td>{{ $post->title }}</td>
                         <td>{{ $post->slug }}</td>
                         <td>{{ $post->author }}</td>
                         <td>
                             <a class="btn btn-dark" href="{{ route('admin.posts.show', ['post' => $post->id ]) }}">
                                 Visualizza
                             </a>
                             <a class="btn btn-secondary" href="{{ route('admin.posts.edit', ['post' => $post->id ]) }}">
                                 Modifica
                             </a>
                             <!-- Bottone che attiva un modal di Bootstrap per la conferma dell'operzione di cancellazione-->
                             {{-- NOTA IMPORTANTE: per rendere univoco l'id del modal concateno al nome l'id del Post (con la stringa "_{{ $post->id }}") --}}
                             <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal_{{ $post->id }}">
                                 Elimina
                             </button>

                             <!-- Modal per la conferma cancellazione post -->
                             <div class="modal fade" id="deleteConfirmationModal_{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalTitle_{{ $post->id }}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered" role="document">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="deleteConfirmationModalTitle_{{ $post->id }}">Cancellazione del Post</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <div class="modal-body">
                                             ATTENZIONE: questa operazione non è reversibile, vuoi veramente cancellare il post?
                                         </div>
                                         <div class="modal-footer">

                                             {{-- bottone per eseguire la cancellazione di un post --}}
                                             <form class="d-inline" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                                                 @method('DELETE')
                                                 @csrf
                                                 <input class="btn btn-danger" type="submit" value="Confermo">
                                             </form>

                                             <button type="button" class="btn btn-warning" data-dismiss="modal">Annulla</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="5">Non c'è alcun post</td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>
     </div>
 </div>
 @endsection