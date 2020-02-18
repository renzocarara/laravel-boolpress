@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Lista di tutti i post per la gestione admin</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
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
