 {{-- url: 'admin/posts'
 nome route: 'admin.posts.index'
 nome view: 'index' (nella cartella views/admin/posts/)
 controller:  'PostController' (nella cartella Controllers\Admin\)
 metodo che la richiama: 'index'  --}}

 {{-- Questa pagina visualizza tutti i posts recuperati dal DB}}
 {{-- la view riceve infatti un parametro in ingresso (post) che rappresenta la collection --}}
 {{-- dei dati letti dal DB (dal metodo PostController@index) --}}
 {{-- Tramite i pulsanti nella colonna Azioni, sarà possibile eseguire delle CRUD sui posts --}}

 @extends('layouts.admin')

 @section('content')
 <div class="container">
     <div class="row">
         <div class="col-12">
             <h1>Tutti i post</h1>
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
                             <a class="btn btn-info" href="{{ route('admin.posts.show', ['post' => $post->id ]) }}">
                                 Visualizza
                             </a>
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