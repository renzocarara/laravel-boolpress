@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="d-inline-block mb-5">Errore 404: pagina non trovata</h1>
            <a class="btn btn-primary float-right" href="{{ route('public.home') }}">Torna in homepage</a>
            <div class="alert alert-warning" role="alert">
                <p>La pagina che stai cercando non esiste!</p>
            </div>
        </div>
    </div>
</div>
@endsection