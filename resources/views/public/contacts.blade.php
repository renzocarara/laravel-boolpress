@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h1>{{ __('messages.contacts_title')}}</h1>
            {{-- questo form richiama una rotta che riceve in post i dati inseriti dall'utente --}}
            {{-- e tramite la funzione contactsStore() li memorizza nel DB --}}
            <form action="{{ route('public.contacts.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('messages.name') }}:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('messages.email') }}:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="subject">{{ __('messages.subject') }}:</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="{{ __('messages.subject') }}" required>
                </div>
                <div class="form-group">
                    <label for="content">{{ __('messages.message') }}:</label>
                    <textarea class="form-control" id="message" placeholder="{{ __('messages.write_here') }}..." name="message" rows="8" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="{{ __('messages.send_msg') }}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
