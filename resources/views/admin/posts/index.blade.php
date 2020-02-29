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
                         <th>Categoria</th>
                         <th>Tag</th>
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
                         {{-- se non è associata una categoria al post, visualizzo solo un trattino '-' --}}
                         <td>{{ $post->category ? $post->category->name : '-' }}</td>
                         <td>
                             @forelse ($post->tags as $tag)
                             {{ $tag->name }}{{ $loop->last ? '' : ',' }}
                             @empty
                             {{-- se non è associato nessun tag, visualizzo solo un trattino '-' --}}
                             -
                             @endforelse
                         </td>
                         <td>
                             <a class="btn btn-dark mt-1" href="{{ route('admin.posts.show', ['post' => $post->id ]) }}">
                                 Visualizza
                             </a>
                             <a class="btn btn-secondary mt-1" href="{{ route('admin.posts.edit', ['post' => $post->id ]) }}">
                                 Modifica
                             </a>
                             <!-- Bottone che usa un modal di Bootstrap per richiedere la conferma dell'operzione di cancellazione-->
                             @include('admin.posts.common.delete_confirmation')
                         </td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="5">Non c'è alcun post</td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
             {{-- paginazione fatta automaticamente da Laravel --}}
             {{ $posts->links() }}
         </div>
     </div>
 </div>
 @endsection
