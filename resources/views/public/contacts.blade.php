@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Compila il form e mandaci un messaggio!</h1>
            {{-- questo form richiama una rotta che riceve in post i dati inseriti dall'utente --}}
            {{-- e tramite la funzione contactsStore() li memorizza nel DB --}}
            <form action="{{ route('public.contacts.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Oggetto:</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Oggetto" required>
                </div>
                <div class="form-group">
                    <label for="content">Messaggio:</label>
                    <textarea class="form-control" id="message" placeholder="Inizia a scrivere..." name="message" rows="8" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Invia messaggio">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection